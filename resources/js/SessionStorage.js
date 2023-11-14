let Oggetto2 = {};
Oggetto2.setItem = (name,value,jsonStringify) => {
    if(value !== null) {
        jsonStringify ? window.sessionStorage.setItem(name,JSON.stringify(value)) : window.sessionStorage.setItem(name,value);
    } else {
        window.sessionStorage.removeItem(name);
    }
};

Oggetto2.removeItem = (name) => {
    window.sessionStorage.removeItem(name);
};

Oggetto2.clear = () => {
    window.sessionStorage.clear()
};

Oggetto2.getItem = (name, value,jsonParse) => {
    let temp = window.sessionStorage.getItem(name);
    let flag = false;
    if(temp === null || temp === "") {
        temp = value;
        flag = true;
    }
    if(jsonParse && !flag) {
        temp = JSON.parse(temp);
    }

    return temp;
};
export default Oggetto2;
