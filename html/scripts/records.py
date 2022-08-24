from datetime import datetime
import uuid
import pickle


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
    
    def __init__(self):
        self.id = f'clev-{uuid.uuid4()}'
        self.time = datetime.now().strftime('%Y-%m-%d, %I:%M:%S %p')
        self.sign = None
        self.data = {}
        self.save()

    def save(self):
        Data.save_to_file('clinicalevents', self)

    def load(id):
        return Data.load_from_file('clinicalevents', id)


class Patient:
    
    def __init__(self, id, surname, lastname):
        self.id = id
        self.events = []
        self.add_to_index([id, surname, lastname])

    def add_to_index(self, data):
        with open(patient_index_path, 'a') as file:
            file.write('|'.join(data))
            file.write('\n')

    def add_event(self, event: ClinicalEvent):
        self.events += [(event.id, event.time)]
        self.save()

    def del_event(self, eventid):
        self.events = [ evt for evt in self.events if evt.id != eventid ]
        self.save()

    def save(self):
        Data.save_to_file('patients', self)

    def load(id):
        return Data.load_from_file('patients', id)

    def get_dict(self, surname, lastname):        
        return {
            'surname': surname,
            'lastname': lastname,
            'id': self.id,
            'events': self.events
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
            for surname, lastname, id in self.filtered:
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