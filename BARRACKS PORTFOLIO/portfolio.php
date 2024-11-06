from flask import Flask, request, jsonify
from flask_mail import Mail, Message

app = Flask(__name__)

# Email configuration
app.config['MAIL_SERVER'] = 'smtp.gmail.com'  # Use your mail server
app.config['MAIL_PORT'] = 587
app.config['MAIL_USERNAME'] = 'your-email@gmail.com'  # Your email
app.config['MAIL_PASSWORD'] = 'your-email-password'  # Your email password (consider using an app password)
app.config['MAIL_USE_TLS'] = True
app.config['MAIL_USE_SSL'] = False

mail = Mail(app)

@app.route('/submit-form', methods=['POST'])
def submit_form():
    # Get data from the form
    name = request.form['name']       # Ensure these match your HTML form field names
    email = request.form['email']
    message = request.form['message']

    # Create email message
    msg = Message(f"Message from {name}", sender=email, recipients=['your-email@gmail.com'])
    msg.body = f"Name: {name}\nEmail: {email}\nMessage: {message}"
    
    try:
        mail.send(msg)  # Send the email
        return jsonify({'message': 'Message sent successfully!'}), 200
    except Exception as e:
        return jsonify({'error': str(e)}), 500  # Return error if sending fails

if __name__ == '__main__':
    app.run(debug=True)  # Run the app in debug mode
