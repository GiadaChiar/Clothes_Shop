

import Title from "../components/title";
import Input from "../components/input";
import Button from "../components/button";
import PopUp from "../components/popUp";

import { DropDown } from "../components/dropdown";
import { useState } from "react";
import { SearchUser } from "../function/SearchUser";


import { useLocation } from "react-router-dom";
import { validationInput } from "../function/Validation";
//import { useNavigate } from "react-router-dom";
import { getAllValutations } from "../function/getAll";
import Loading from "../components/loading";
//import { useEffect } from "react";
import "../style/global.css";


import  GenericCard  from "../components/genericCard";




export default function Valutation() {


    //const navigate = useNavigate();
    const location = useLocation();

    const [getCategory, setCategory] = useState("");
    const [getBrand, setBrand] = useState("");
    const [getState, setState] = useState("");
    const [getImage, setImage] = useState("");
    //output card
    const [result, setResult] = useState(null);
    const [allResults, setAllResults] = useState([]);
    const [loading, setLoading] = useState(false);
    const [mode, setMode] = useState(null);
    // "single" | "list" | null


    const [popup, setPopup] = useState({
        visible: false,
        alert: "",
        message: ""
    });

    //get id_user pass during registratio/login
    const user_id = location.state?.data;
    console.log("data ricevuto:", user_id);


    //get all valutataions
    const handleAll = async () => {
        console.log("Cliccato ALL")
        setLoading(true);
       
        //try {
        
        setMode("list"); 
        setAllResults([]);
        setResult(null);

        const res = await getAllValutations(user_id);
        
        if (res) {
            console.log("risultato arrivato : ", res);
            setAllResults(res.data);
            
            
        } else {
            console.log("non arrivato");
        }


        setLoading(false);
        console.log("loading OFF");
    };

    
    const handleValutation = async () => {
        console.log("CLICK FUNZIONA");
        setLoading(true);
        setMode("single"); 
        setAllResults([]);
        

        const brand = validationInput(getBrand);

        if (!getCategory || !brand || !getState || !getImage) {
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



           
            setResult(null);
            setAllResults([])

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
                        message: user.data
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
     finally {
        setLoading(false); 
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

                {loading && <Loading />}

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

                    <div>
                    <Button
                        id="btn_valutation"
                        className="showALL"
                        label="TUTTE LE VALUTAZIONI"
                        type="button"
                        onClick={handleAll}

                        />
                    </div>
                
                <div id="cartSection">

                    {loading && <Loading />}

                    {!loading && mode === "single" && result && (
                        <GenericCard data={result} />
                    )}

                    {!loading && mode === "list" && allResults.map(item => (
                        <GenericCard key={item.id_item} data={item} />
                    ))}

                </div>
            </div>
        </>


    )
}


























