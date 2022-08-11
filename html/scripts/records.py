from datetime import datetime
import uuid
import pickle


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
        self.time = datetime.now().strftime('%Y-%m-%d, %H:%M:%S')
        self.sign = None
        self.data = {}
        self.save()

    def save(self):
        Data.save_to_file('clinicalevents', self)

    def load(id):
        return Data.load_from_file('clinicalevents', id)


class Patient:
    
    def __init__(self, id):
        self.id = id
        self.events = []

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