

//get valuatation of emai,name,surname and two password for registration
import { validationPassword } from "./Validation";
import { validationEmail } from "./Validation";
import { validationInput } from "./Validation";

export default function CheckRegistration(getEmail, getName, getSurname, getPassword, getCopyPassword, setPopup) {

    console.log("CLICK FUNZIONA");

    if (!getEmail || !getSurname || !getName || !getCopyPassword || !getPassword) {
        setPopup({
            visible: true,
            alert: "Errore",
            message: "Compila tutti i campi richiesti"
        });
        return;
    }

    const password = validationPassword(getPassword);
    if (!password) {
        setPopup({
            visible: true,
            alert: "Password errata",
            message: "La password deve contenere almeno 8 caratteri di cui uno speciale"
        });
        return;
    }
    if (password !== getCopyPassword.trim()) {
        setPopup({
            visible: true,
            alert: "Password errate",
            message: "Le password devono essere identiche"
        });
        return;
    }

    const email = validationEmail(getEmail);
    if (!email) {
        setPopup({
            visible: true,
            alert: "Email errata",
            message: "Email nel formato errato, riprovare"
        });
        return;
    }

    const name = validationInput(getName);
    const surname = validationInput(getSurname);
    return {
        email,
        name,
        surname,
        password
    };
    ;

}