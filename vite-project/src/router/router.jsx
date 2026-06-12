//create root for navigation pages

import LogIn from "../pages/logIn.jsx";
import Registration from "../pages/Registration.jsx";
import Valutation from "../pages/valutation.jsx";
import { Routes, Route } from "react-router-dom";

export default function NavigationRoots() {
    return (
        <>
            <Routes>
                <Route path="/" element={<LogIn />} />
                <Route path="/iscriviti" element={<Registration />} />
                <Route path="/valuta" element={<Valutation />} />
            </Routes>
        </>
    )
}