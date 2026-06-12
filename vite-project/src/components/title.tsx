//title 

type TitleProps = {
    classname: string;
    id?: string;
    text: string;
};

export default function Title({ classname, id, text }: TitleProps
) {
    return (
    <h1
        id={id}
        className={classname}>
        {text}
    </h1>
    );
}