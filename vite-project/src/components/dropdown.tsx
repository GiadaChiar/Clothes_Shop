//standard dropdown to use in the Search page

import { useState } from "react";

type Option = {
    label: string;
    value: string;
};

type DropdownProps = {
    label: string;
    id: string;
    options: Option[];
    onSelect: (value: string, label: string) => void;
};



export function DropDown({ label, id, options, onSelect }: DropdownProps) {

    //check selection 
    const [selectedLabel, setSelected] = useState<Option | null>(null);

    //if I click get value and label, use it onSelect
    const handleClick = (
        e: React.MouseEvent<HTMLButtonElement>,
        option: Option
    ) => {
        e.preventDefault();
        setSelected(option);
        onSelect(option.value, option.label);
    };

    return (
        <div className="dropdown" id={id}>
            <button
                className="btn btn-secondary dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
            >
                {selectedLabel?.label ?? label}
            </button>

            <ul className="dropdown-menu">

                {options.map((option) => (
                    <li key={option.value}>
                        <button
                            className="dropdown-item"
                            onClick={(e) => handleClick(e, option)}
                        >
                            {option.label}
                        </button>
                    </li>
                ))}

            </ul>
        </div>
    );
}



