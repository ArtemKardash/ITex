let runningTotal = 0;
let buffer = "0";
let previousOperator;
const history = [];

const screen = document.querySelector('.result');
const historyList = document.querySelector('#historyList');

function buttonCLick(value){
    if(isNaN(value)) {
        handleSymbol(value);
    } else {
        handleNumber(value);
    }
    screen.innerText = buffer;
}

function handleSymbol(symbol){
    switch(symbol){
        case 'C':
            buffer = '0';
            runningTotal = 0;
            break;
        case '=':
            if(previousOperator === null){
                return;
            }
            flushOperation(parseInt(buffer));
            previousOperator = null;
            buffer = runningTotal;
            updateHistory(buffer);
            runningTotal = 0;
            break;
        case '+':
        case '-':
        case '*':
        case '/':
            handleMath(symbol);
            break;
    }
}

function handleMath(symbol){
    if(buffer === '0'){
        return;
    }

    const intBuffer = parseInt(buffer);

    if(runningTotal === 0){
        runningTotal = intBuffer;
    } else {
        flushOperation(intBuffer);
    }
    previousOperator = symbol;
    buffer = '0';
}

function flushOperation(intBuffer){
    if(previousOperator === '+'){
        runningTotal += intBuffer;
    } else if(previousOperator === '-'){
        runningTotal -= intBuffer;
    } else if(previousOperator === '*'){
        runningTotal *= intBuffer;
    } else if(previousOperator === '/'){
        runningTotal /= intBuffer;
    }
}

function handleNumber(numberString){
    if(buffer === "0"){
        buffer = numberString;
    } else {
        buffer += numberString;
    }
}

function updateHistory(result) {
    history.push(result);

    if (history.length > 5) {
        history.shift();
    }

    let historyHTML = '';
    for (let i = 0; i < history.length; i++) {
        historyHTML += `<li>${history[i]}</li>`;
    }
    historyList.innerHTML = historyHTML;
}

function init(){
    document.querySelector('.CalcButtons').addEventListener('click', function(event){
        buttonCLick(event.target.innerText);
    })
}

init();
