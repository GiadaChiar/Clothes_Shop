
//validation email

export function validationEmail(email) {
    const cleanedEmail = email.trim().toLowerCase();

    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    const isValid = regex.test(cleanedEmail);

    if (!isValid) {
        return false;
    }

    return cleanedEmail;
}


//validation  password

export function validationPassword(password) {

    const clean = password.trim();

    const lenght_password = clean.length >= 8;
    const special = /^(?=.*[!@#$%^&*(),.?":{}|<>])[^\s]{8,}$/.test(password)

    if (lenght_password && special)
        return password
}


//validation Input


export  function validationInput(input) {

    const cleanInput = input.trim().toLowerCase();
    
    return cleanInput;
}