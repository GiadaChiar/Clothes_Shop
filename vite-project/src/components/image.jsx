import { useState } from "react";

export default function UploadImage({ onUpload }) {

    const [preview, setPreview] = useState(null);

    const handleChange = (e) => {
        const file = e.target.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = () => {
            const base64 = reader.result;

            setPreview(base64);   // opzionale: per vedere immagine
            onUpload(base64);     // manda al parent
        };
    };

    return (
        <div>
            <input type="file" accept="image/*" onChange={handleChange} />

            {preview && (
                <img
                    src={preview}
                    alt="preview"
                    style={{ width: "200px", marginTop: "10px" }}
                />
            )}
        </div>
    );
}