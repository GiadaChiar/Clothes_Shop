//get valutation of  emai end password for login 
import { validationPassword } from "./Validation";
import { validationEmail } from "./Validation";

export default  function handleValidation(getEmail, getPassword, setPopup) {

    
    const email = validationEmail(getEmail)
    const password = validationPassword(getPassword);
    if (!password) {
        setPopup({
            visible: true,
            alert: "Password errata",
            message: "La password deve contenere almeno 8 caratteri di cui uno speciale"
        });
        return null;
    }

    if (!email) {
        setPopup({
            visible: true,
            alert: "Email errata",
            message: "Email nel formato errato, riprovare"
        });
        return null;
    }
        return {
            email,
            password
        };
    }

