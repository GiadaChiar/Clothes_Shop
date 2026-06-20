import Title from "../components/title";
import Input from "../components/input";
import List from "../components/list";
import PopUp from "../components/popUp";
import "../style/global.scss";
import { useState } from "react";
import Button from "../components/button";
import { Link } from "react-router-dom";
import handleValidation from "../function/ValidationLogin";
import { useNavigate } from "react-router-dom";
import { loginService } from "../services/authService";



//login function
export function LogIn() {

    const navigate = useNavigate();

    //get input
    const [getEmail, setEmail] = useState("");
    const [getPassword, setPassword] = useState("");
    const [popup, setPopup] = useState({
        visible: false,
        alert: "",
        message: ""
    });

    const handleLogIn = async () => {
        const credentials = handleValidation(
            getEmail,
            getPassword,
            setPopup
        );

        if (!credentials) return;

        try {
            const user = await loginService(
                credentials.email,
                credentials.password
            );

            if (user.type === "login") {

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
                        message: "Bentornato"
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
                alert: "Problemi Tecnici",
                message: "La richiesta non è andata a buon fine. Riprovi per favore."
            });
            return;
        }
    }
    return (
        <>
            <div className="page">
                <Title
                    classname="title"
                    id="title_login"
                    text="LooKBook"
                />

                <h2 className="title2">Ridai una vita ai tuoi vestiti</h2>

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

                <div id="input_login" className="inLine">
                    <Input
                        id="email"
                        type="email"
                        placeholder="miaemail@gmail.com"
                        id_span="email_span"
                        text_span="Email"
                        onChange={(e) =>
                            setEmail(e.target.value)
                        }
                    />

                    <Input
                        id="password"
                        type="password"
                        placeholder="password"
                        id_span="span_password"
                        text_span="password"
                        onChange={(e) =>
                            setPassword(e.target.value)
                        }
                    />
                </div>

                <div>
                    <Button
                        id="btn_logIn"
                        className="buttonSend"
                        label="ACCEDI"
                        type="submit"
                        onClick={handleLogIn}
                    />
                </div>

                <div>
                    <Link className="navbar-brand" to="/iscriviti">
                        {"Sei nuovo? Registrati!"}
                    </Link>
                </div>

                <List />
            </div>
        </>
    );
}

export default LogIn;
