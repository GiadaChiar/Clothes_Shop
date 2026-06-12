//create standard input
import React from "react";

type InputProps = {
    id: string;
    placeholder: string;
    value?: string;
    id_span: string;
    type: string;
    text_span: string;
    onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
} & React.InputHTMLAttributes<HTMLInputElement>

export default function Input({  id, type, placeholder, value,id_span,text_span, onChange, ...props }: InputProps) {
    return (
    
        <div className="input-group mb-3">
            <span className="input-group-text"
                id={id_span}>{text_span}</span>
                <input
                className= "form-control"
                id={id}
                type={type}
                    placeholder={placeholder}
                    value={value}
                    onChange={onChange}
                        {...props}
                    />
        </div>
    );
}



