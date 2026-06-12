import Title from "../components/title";
import Input from "../components/input";
import Button from "../components/button";
import PopUp from "../components/popUp";

import { DropDown } from "../components/dropdown";
import { useState } from "react";
import { SearchUser } from "../function/SearchUser";
import ValutationCard from "../components/ValutationCart";
import { useLocation } from "react-router-dom";
import { validationInput } from "../function/Validation";
import { useNavigate } from "react-router-dom";
import "../style/global.css";




export default function Valutation() {

    const navigate = useNavigate();
    const location = useLocation();

    const [getCategory, setCategory] = useState("");
    const [getBrand, setBrand] = useState("");
    const [getState, setState] = useState("");
    const [getImage, setImage] = useState("");
    //output card
    const [result, setResult] = useState(null);

    
    const [popup, setPopup] = useState({
        visible: false,
        alert: "",
        message: ""
    });
    
    //get id_user pass during registratio/login
    const user_id = location.state?.data;
    console.log("data ricevuto:", user_id);

    if (!user_id) {
        setPopup({
            visible: true,
            alert: "Errore tecnico",
            message: "  Ci scusiamo per il disagio, deve rieffettuare il login"
        });
        navigate("/");
        return;
    }



    const handleValutation = async () => {
        console.log("CLICK FUNZIONA");
        
        const brand = validationInput(getBrand);

                if (!getCategory || !brand|| !getState || !getImage) {
                    setPopup({
                        visible: true,
                        alert: "Errore",
                        message: "Compila tutti i campi richiesti"
                    });
                    return;
                }
            //console.log("image ", getImage)
            console.log("categort", getCategory);
            console.log("STATE ", getState);
        console.log("Brand ", brand);
            
    
                try {
                    const user = await SearchUser({
                        request: "valutation",
                        category: getCategory,
                        state: getState,
                        brand: brand,
                        image: getImage, 
                        user_id: user_id,
                    })

                    //answer fetch

                    console.log("mio user", user);
                    console.log("arrivato richiesta", user.debug.type)

                    if (user.debug.type === "valutation") {
                        
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
                                alert: "Valutazione avvenuta",
                                message: ""
                            });

                            console.log("arrivato in ", user.success);

                            const aiData = user.debug;



                            setResult(aiData);
                            console.log("result eseguito")
                        }
                            //set data response
                            if (!user) {
                                setPopup({
                                    visible: true,
                                    alert: "Valori non trovati in data",
                                    message:user.data
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
                classname="title"
                id="title_valutation"
                text="VALUTA IL TUO ARTICOLO"
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

            <div className="dropdowns">
            <DropDown
                label="CATEGORIA"
                id="category_drop"
                options={[
                    { label: "Maglia", value: "maglia" },
                    { label: "Maglione", value: "maglione" },
                    { label: "Maglietta", value: "maglietta" },
                    { label: "Canotta", value: "canotta" },
                    { label: "Pantalone", value: "pantalone" },
                    { label: "Jeans", value: "jeans" },
                    { label: "Pantaloncino", value: "pantaloncino" },
                    { label: "Pantagonna", value: "pantagonna" },
                    { label: "Gonna", value: "gonna" },
                ]}
                onSelect={(value) => setCategory(value)}
            />

            <DropDown
                label="STATO"
                id="state_drop"
                options={[
                    { label: "Nuovo", value: "nuovo" },
                    { label: "Buono", value: "buono" },
                    { label: "Usato", value: "usato" },
                ]}
                onSelect={(value) => setState(value)}
            />

            </div>
            <Input
                id="brand"
                type="text"
                placeholder="Gucci"
                id_span="brand_span"
                text_span="Brand"
                onChange={(e) =>
                    setBrand(e.target.value)
                }
            />
            <div id="file">
            <input
                type="file"
                accept="image/*"
                onChange={(e) => {

                    const file = e.target.files[0];

                    if (!file) return;

                    const reader = new FileReader();
                    //save into base64
                    reader.readAsDataURL(file);
                    // 64 like string
                    reader.onload = () => {
                        setImage(reader.result); // 🔥 base64
                    };
                }}
                    />
                </div>
            <div>
            <Button
                id="btn_valutation"
                className="buttonSend"
                label="VALUTA"
                type="submit"
                onClick={handleValutation}
                
                    />
                </div>
            <div id ="cartSection">
                    {result && <ValutationCard data={result} />}
                </div>
            </div>
        </>

        
    )
}
















