/*
import Title from "../components/title";
import Input from "../components/input";
import Button from "../components/button";
import PopUp from "../components/popUp";
import { DropDown } from "../components/dropdown";
import { useState } from "react";
import { valutation } from "../api/authApi";
import { useLocation } from "react-router-dom";
import { validationInput } from "../function/Validation";
import { getAllValutations } from "../api/authApi";
import timeout from "../function/Timeout";
import Loading from "../components/loading";
import "../style/global.css";
import GenericCard from "../components/genericCard";


//insert valutation
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
            if (res.success === true) {
                console.log("risultato arrivato : ", res);
                setAllResults(res.data);
            }
            if (res.success === false) {
                setPopup({
                    visible: true,
                    alert: "Attenzione",
                    message: res.error,
                });
            }
        } else {
            setPopup({
                visible: true,
                alert: "Problemi tecnici",
                message: "La richiesta non è andata a buon fine. Riprovi per favore."
            });
            return;
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

            setLoading(false);
            return;
        }
        //console.log("image ", getImage)
        console.log("categort", getCategory);
        console.log("STATE ", getState);
        console.log("Brand ", brand);


        try {
            const user = await Promise.race([
                valutation({
                    request: "valutation",
                    category: getCategory,
                    state: getState,
                    brand: brand,
                    image: getImage,
                    user_id: user_id,
                }),
                timeout(10000)//10s
            ]);

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
            }

        } catch (error){

            if (error.message === "TIMEOUT") {
                setPopup({
                    visible: true,
                    alert: "Timeout",
                    message: "Il server sta impiegando troppo tempo. Riprova."
                });
            } else {
            
                setPopup({
                    visible: true,
                    alert: "Problemi tecnici",
                    message: "La richiesta non è andata a buon fine. Riprovi per favore."
                });
            }
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



*/







import Title from "../components/title";
import Input from "../components/input";
import Button from "../components/button";
import PopUp from "../components/popUp";
import { DropDown } from "../components/dropdown";
import { useState } from "react";
//import { valutation } from "../api/authApi";
import { useLocation } from "react-router-dom";
import { validationInput } from "../function/Validation";
import { AllValutations } from "../services/itemService";
import { valutation } from "../api/authApi";
import timeout from "../function/Timeout";
import Loading from "../components/loading";
import "../style/global.css";
import GenericCard from "../components/genericCard";


//insert valutation
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

        const res = await AllValutations(user_id);

        if (res) {
            if (res.success === true) {
                console.log("risultato arrivato : ", res);
                setAllResults(res.data);
            }
            if (res.success === false) {
                setPopup({
                    visible: true,
                    alert: "Attenzione",
                    message: res.error,
                });
            }
        } else {
            setPopup({
                visible: true,
                alert: "Problemi tecnici",
                message: "La richiesta non è andata a buon fine. Riprovi per favore."
            });
            return;
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

            setLoading(false);
            return;
        }
        //console.log("image ", getImage)
        console.log("categort", getCategory);
        console.log("STATE ", getState);
        console.log("Brand ", brand);
       
        try {
            const user = await Promise.race([
                valutation({
                    request: "valutation",
                    category: getCategory,
                    state: getState,
                    brand: brand,
                    image: getImage,
                    user_id: user_id,
                }),
                timeout(10000)//10s
            ]);

        

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
            }

        } catch (error) {

            if (error.message === "TIMEOUT") {
                setPopup({
                    visible: true,
                    alert: "Timeout",
                    message: "Il server sta impiegando troppo tempo. Riprova."
                });
            } else {

                setPopup({
                    visible: true,
                    alert: "Problemi tecnici",
                    message: "La richiesta non è andata a buon fine. Riprovi per favore."
                });
            }
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


























































































