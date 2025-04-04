document.getElementById('contactForm').addEventListener('submit', function(event) {
  event.preventDefault();  // Zapobiegaj domyślnemu wysyłaniu formularza
  
  // Pobieranie wartości z pól
  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const message = document.getElementById('message').value.trim();
  const phone = document.getElementById('phone').value.trim();
  const age = document.getElementById('age').value.trim();

  // Pobieranie wartości z pól typu radio
  const gender = document.querySelector('input[name="gender"]:checked')?.value || "Nie podano";

  // Pobieranie wartości z checkboxów
  const interests = Array.from(document.querySelectorAll('input[name="interests"]:checked'))
    .map(checkbox => checkbox.value)
    .join(", ") || "Brak zainteresowań";

    const contactConsent = Array.from(document.querySelectorAll('input[name="contactConsent"]:checked'))
    .map(checkbox => checkbox.value)
    .join(", ") || "Brak zgody";


  clearErrors();
   
  let isValid = true;

  if (name.length < 2) {
    displayError('name', 'Imię musi mieć co najmniej 2 znaki')
    isValid = false;
  }

  if (message.length < 5) {
    displayError('message', 'Wiadomość musi mieć co najmniej 5 znaków')
    isValid = false;
  }

  if (age < 18 || age > 120) {
    displayError('age', 'Wprowadź poprawny wiek między 18 a 120')
    isValid = false;
  }

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const phonePattern =  /^\d{9}$/;
  if (!emailPattern.test(email)) {
    displayError('email','Podaj poprawny adres e-mail');
    isValid = false;
  }

  if (!phonePattern.test(phone)) {
    displayError('phone','Podaj poprawny numer telefonu');
    isValid = false;
  }
  
 


  // Wyświetlanie danych w podsumowaniu
  if(isValid) {
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = `
      <h3>Podsumowanie:</h3>
      <p><strong>Imię:</strong> ${name}</p>
      <p><strong>E-mail:</strong> ${email}</p>
      <p><strong>Płeć:</strong> ${gender}</p>
      <p><strong>Zainteresowania:</strong> ${interests}</p>
      <p><strong>Zgoda na kontakt:</strong> ${contactConsent}</p>
      <p><strong>Numer Telefonu:</strong> ${phone}</p>
      <p><strong>Wiek:</strong> ${age}</p>
      <p><strong>Wiadomość:</strong> ${message}</p>
    `;
  }

  
});

function clearErrors(){
  const errors = document.getElementsByClassName('error-message');
  while(errors.length > 0) {
    errors[0].parentNode.removeChild(errors[0]);
  }
}

function displayError(fieldId, message) {
  const field = document.getElementById(fieldId);
  const errorDiv = document.createElement('div');
  errorDiv.className = 'error-message';
  errorDiv.textContent = message;
  // errorDiv.style.color = 'red';
 field.parentNode.insertBefore(errorDiv, field.nextElementSibling);
}