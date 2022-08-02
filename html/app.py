#!/usr/bin/python3

from flask import Flask, render_template, request, session, redirect, url_for, send_from_directory
from flask_socketio import SocketIO, emit

from scripts.user import User

import os
import pdfkit

app = Flask(__name__, instance_relative_config = True)
app.secret_key = 'sigma'

socketio = SocketIO(app, cors_allowed_origins = '*', async_mode='gevent') #, logger=True, engineio_logger=True)

os.chdir(os.path.dirname(__file__))

def login_user(user, passwd):
    '''Login user to session'''
    user = User(user, passwd)
    if user.status == 'authenticated':
        session['u'] = user.id
        session['p'] = user.data['password']
    return user, passwd

def logged_user():
    '''Retrieves logged user'''
    return User(session.get('u'), session.get('p'), hashed = True)

@app.route('/')
def index():
    # Requires logged user
    user = logged_user()
    if user.status != 'authenticated':
        return redirect(url_for('login'))

    return render_template('index.html',
            user=user)

@app.route('/login', methods=['GET', 'POST'])
def login():
    # Verifies if user is logged
    user = logged_user()
    if user.status == 'authenticated':
        return redirect(url_for('.index'))

    if request.method == 'POST':
        result = login_user(request.values.get('user'),
                            request.values.get('password'))
        return render_template('login.html', result = result)

    return render_template('login.html')

@app.route('/logout')
def logout():
    session.clear()
    return redirect(url_for('login'))

@app.route('/download', methods=['POST'])
def download():
    '''Saves schedule pdf to file, and return path and filename for download'''
    # Retrieve schedule from file
    sched = '' #Schedule.load_from_file(request.values.get('id'))

    # Create temp folder if not exists
    dir = '/tmp/acuatur'
    os.makedirs(dir, exist_ok=True)

    filename = f'{sched.id}.pdf' # Filename in temp folder
    download_name = f'{sched.group.name} - {sched.get_month().title}.pdf' # Filename for user

    # Generates PDF
    css = [ 'static/css/base.css', 'static/css/schedule.css' ]
    options = {
        'enable-local-file-access': '',
        'page-size': 'Letter',
        'margin-top': '0.75in',
        'margin-right': '0.75in',
        'margin-bottom': '0.75in',
        'margin-left': '0.75in',
        'encoding': "UTF-8",
        'custom-header': [
            ('Accept-Encoding', 'gzip')
        ],
    }

    pdfkit.from_string(
            'titulo',
            os.path.join(dir, filename),
            css = css,
            options = options,
            verbose = True
        )

    # Return PDF to user
    return send_from_directory(directory=dir,
                                filename=filename,
                                path=filename,
                                download_name=download_name,
                                as_attachment=True)

@app.route('/password', methods=['GET', 'POST'])
def password():
    # Requires logged user
    user = logged_user()
    if user.status != 'authenticated':
        return redirect(url_for('login'))

    # Updates password
    if request.method == 'POST':
        res = user.update_password(request.values['old_password'], request.values['new_password'])
        return render_template('password.html', user = user, result = res)

    return render_template('password.html', user = user)

@app.route('/dashboard')
def dashboard():
    pass