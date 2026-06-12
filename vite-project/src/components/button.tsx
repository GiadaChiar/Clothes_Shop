//props to pass to Button



type ButtonProps = {
    className: string;
    id:string,
    label: string;
    type: "button" | "submit";
    onClick: () => void;
};

export default function Button({ className ,id,label,type, onClick}: ButtonProps
) {
    return (
    <button
            className={className}
        type={type}
        onClick = {onClick}
        >
        {label}
        </button>
    );
}