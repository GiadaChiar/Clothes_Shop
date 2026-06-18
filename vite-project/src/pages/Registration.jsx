


import Title from "../components/title";
import Input from "../components/input";
import Button from "../components/button";
import PopUp from "../components/popUp";
import "../style/global.css";

import { useState } from "react";
import { Link } from "react-router-dom";
import { registerUser } from "../api/authApi";
import { useNavigate } from "react-router-dom";
import CheckRegistration from "../function/ValutationRegistration";


export default function Registration() {
    const navigate = useNavigate();
    //get input
    const [getEmail, setEmail] = useState("");
    const [getName, setName] = useState("");
    const [getSurname, setSurname] = useState("");
    const [getPassword, setPassword] = useState("");
    const [getCopyPassword, setCopyPassword] = useState("");
    const [popup, setPopup] = useState({
        visible: false,
        alert: "",
        message: ""
    });

    const handleRegistration = async () => {

        const credentials = CheckRegistration(
            getEmail,
            getName,
            getSurname,
            getPassword,
            getCopyPassword,
            setPopup
        )

        if (!credentials) return;
        console.log("credenziali trovate", credentials);

        const email = credentials.email;
        const name = credentials.name;
        const surname = credentials.surname;
        const password = credentials.password;


        try {
            const user = await registerUser({
                request: "registration",
                email: email,
                name: name,
                surname: surname,
                password_hash: password,

            })
            console.log("richiesta che è tornata", user);
            if (user.type === "registration") {
                console.log("arrivato richiesta", user.type)
                if (user.success === false) {
                    setPopup({
                        visible: true,
                        alert: "Attenzione",
                        message: user.error,
                    });
                }
                if (user.success === true) {
                    setPopup({
                        visible: true,
                        alert: "Registrazione eseguita",
                        message: "Benvenuto"
                    });
                    navigate("/valuta", {
                        state: {
                            data: user.data
                        }
                    });
                    return;

                }
            }

        } catch {
            setPopup({
                visible: true,
                alert: "Problemi tecnici",
                message: "La richiesta non è andata a buon fine. Riprovi per favore."
            });
            return;
        }
    }


    return (
        <>
            <div className="page">
                <Title
                    classname="tile"
                    id="title_registration"
                    text="ISCRIVITI"
                />

                {popup.visible && (
                    <PopUp
                        alert={popup.alert}
                        message={popup.message}
                        onClose={() =>
                            setPopup({
                                visible: false,
                                alert: "",
                                message: ""
                            })
                        }
                    />
                )}

                <div className="inLine">
                    <Input
                        id="email_reg"
                        type="email"
                        placeholder="miaemail@gmail.com"
                        id_span="email_span_reg"
                        text_span="Email"
                        onChange={(e) =>
                            setEmail(e.target.value)
                        }
                    />

                    <Input
                        id="name"
                        type="text"
                        placeholder="Mario"
                        id_span="name_span"
                        text_span="Nome"
                        onChange={(e) =>
                            setName(e.target.value)
                        }
                    />

                    <Input
                        id="surname"
                        type="text"
                        placeholder="Rossi"
                        id_span="surname_span"
                        text_span="Cognome"
                        onChange={(e) =>
                            setSurname(e.target.value)
                        }
                    />

                    <Input
                        id="password_reg"
                        type="password"
                        placeholder="password"
                        id_span="span_password_reg"
                        text_span="password"
                        onChange={(e) =>
                            setPassword(e.target.value)
                        }
                    />

                    <Input
                        id="password_copy"
                        type="password"
                        placeholder="password_copy"
                        id_span="span_password_copy"
                        text_span="Ripeti password"
                        onChange={(e) =>
                            setCopyPassword(e.target.value)
                        }
                    />
                </div>
                <div>
                    <Button
                        id="btn_registration"
                        className="buttonSend"
                        label="REGISTRATI"
                        type="submit"
                        onClick={handleRegistration}
                    />
                </div>

                <div>
                    <Link className="navbar-brand" to="/">
                        {"Sei già registrato? Accedi!"}
                    </Link>
                </div>
            </div>
        </>
    )
}