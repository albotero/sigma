from datetime import datetime
import pickle
import os
import re


patient_index_path = '../user_data/patients/index'

class Data:

    def save_to_file(datatype, dataobject):
        '''Serializes data and saves it to a file'''
        # Open a file and use dump()
        with open(f'../user_data/{datatype}/{dataobject.id}', 'wb') as file:
            pickle.dump(dataobject, file)

    def load_from_file(datatype, dataid):
        '''Loads a serialized schedule from a file'''
        # Open the file in binary mode
        with open(f'../user_data/{datatype}/{dataid}', 'rb') as file:
            # Call load method to deserialze
            return pickle.load(file)


class ClinicalEvent:
    
    def __init__(self, name, user):
        self.id = self.generate_id()
        self.name = name
        self.time = datetime.now().strftime('%-d/%m/%Y %-I:%M %p')
        self.user = user

        self.sign = None
        self.data = {}

        self.template = 'odontologia'
        self.sections = [
            'mc', 'ea', 'evolucion', 'antecedentes', 'hist_odont', 'tto_previo', 'salud_oral', 'higiene',
            'examen_clinico', 'perio', 'procedimiento', 'diagnostico', 'plan', 'formula'
        ]

        self.save()

    def generate_id(self):
        clev = [ int(re.split(r'-', c)[1]) for c in os.listdir('../user_data/clinicalevents') if 'clev' in c ]
        curr_index = max(clev) if len(clev) else 0
        return f'clev-{curr_index + 1:04d}'

    def save(self):
        Data.save_to_file('clinicalevents', self)

    def load(id, fullname=False):
        return Data.load_from_file('clinicalevents', id if fullname else f'clev-{id}')

    def get_dict(self):
        return {
            'id': self.id.replace('clev-', ''),
            'name': self.name,
            'time': self.time,
            'user': self.user.data["name"],
            'sign': self.sign,
            'data': self.data
        }


class PatientExistsException(Exception):
    def __init__(self, id):
        self.id = id

    def __str__(self):
        return f'El paciente con ID: "{self.id}" ya existe, no se puede crear nuevamente'

class Patient:
    
    def __init__(self, id, surname, lastname):
        # Only creates patient if not exist
        try:
            Patient.load(id)
            raise PatientExistsException(id)
        except IOError:        
            self.id = id
            self.events = []
            self.add_to_index([id, surname, lastname])
            self.save()
        except PatientExistsException as e:
            print(f'Error: {e}')

    def add_to_index(self, data):
        with open(patient_index_path, 'a') as file:
            file.write('|'.join(data))
            file.write('\n')

    def add_event(self, event: ClinicalEvent):
        self.events += [event.id]
        self.save()

    def del_event(self, eventid):
        self.events = [ evt for evt in self.events if evt.id != eventid ]
        self.save()

    def save(self):
        Data.save_to_file('patients', self)

    def load(id):
        return Data.load_from_file('patients', id)

    def get_dict(self, surname = None, lastname = None):
        return {
            'id': self.id,
            'surname': surname,
            'lastname': lastname,
            'events': [ ClinicalEvent.load(e, fullname=True).get_dict() for e in sorted(self.events, reverse=True) ]
        }


class History:
    def __init__(self, filter):
        '''Creates self.patients list to show in frontend history'''
        self.patients = []
        self.filter = filter
        self.filter_patients()
        
        # If a patient has been filtered show that patient's history
        if len(self.filtered) == 1:
            self.patients += [ Patient.load(self.filtered[0][0]).get_dict(*self.filtered[0][1:]) ]
        
        # If there is more than 1 patient filtered only show their names/id
        if len(self.filtered) > 1:
            for id, surname, lastname in self.filtered:
                self.patients += [{ 'id': id, 'surname': surname, 'lastname': lastname }]

    def filter_patients(self):
        '''Return list of patients with frontend filter'''
        self.filtered = []
        try:
            with open(patient_index_path, 'r') as file:
                for line in file:
                    if all([ x in line for x in self.filter.values() if x ]):
                        self.filtered += [ line.strip().split('|') ]
        except IOError:
            return ''