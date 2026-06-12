// Pop to show messages


type PopUpProps = {
    alert: string;
    message: string;
    onClose: () => void;

}

export default function PopUp({ alert, message, onClose }: PopUpProps) {
    return (
        <>
            <div className="custom-popup">
                <div className="popup-box">
                    <h4>{alert}</h4>
                    <p>{message}</p>
                    <button onClick={onClose}>
                        Chiudi
                    </button>
                </div>
            </div>
        </>
    );
}