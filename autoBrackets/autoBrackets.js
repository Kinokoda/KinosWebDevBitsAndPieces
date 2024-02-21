/*
I am a lazy man. and when I write code, I aexpect the program I am in to add the closing brackets/quotes for me.
Discord doen't do that, so I made this little script to do it for me.
Now, this is just a proof of concept, not a ready Vencord script. I will have to do some work to make it work in Vencord.
Made by brtndrTom. Time of writing this is 3:47 AM, 21/2/2024. Goin for a walk in the morning after I wake up.
*/


const openToClosedBrackets = new Map([ //Map of open brackets to their corresponding closed brackets.
    ['(', ')'],
    ['[', ']'],
    ['{', '}'],
    ['<', '>'],
    ['"', '"'],
    ["'", "'"],
]);
const closedToOpenBrackets = new Map([ //Map of closed brackets to their corresponding open brackets.
    [')', '('],
    [']', '['],
    ['}', '{'],
    ['>', '<'],
    ['"', '"'],
    ["'", "'"],
]);

function sleep(ms) //Function to make the program wait for a certain amount of time.
{
  return new Promise(resolve => setTimeout(resolve, ms)); //Returns a promise that resolves after the given amount of time.
}

function fillBrackets(triggerElement)   //Find out if the cursor just input an open bracket. if it did, add the closed bracket.
{   
    sleep(1).then(() => //Waiting so that the input element is updated.
        {
            const cursorPosition = triggerElement.selectionStart; //Getting the cursor position AFTER the update.

            if (!openToClosedBrackets.has(triggerElement.value[cursorPosition - 1]) &&  !closedToOpenBrackets.has(triggerElement.value[cursorPosition - 1])) //Checking if the character just input is not a bracket.
            {
                //console.log("not a bracket"); //Printing to the console for debugging purposes.
            
            }

            else if (openToClosedBrackets.has(triggerElement.value[cursorPosition - 1])) //Checking if the character just input is an open bracket.
            {
                const closer = openToClosedBrackets.get(triggerElement.value[cursorPosition - 1]); //Getting the corresponding closed bracket.
                //console.log("will add:", closer); //Printing the closed bracket to the console for debugging purposes.
                let tempTrigElArr = triggerElement.value.split(''); //Making a temporary array of the text field.
                tempTrigElArr.splice(cursorPosition, 0, closer); //Inserting the closer at the cursor position.
                triggerElement.value = tempTrigElArr.join(''); //Joining the array back into a string.
                triggerElement.setSelectionRange(cursorPosition, cursorPosition); //Setting the cursor position to the original position.
            }

            else
            {
                let tempTrigElArr = triggerElement.value.split(''); //Making a temporary array of the text field.
                if (closedToOpenBrackets.get(triggerElement.value[cursorPosition - 1]) == triggerElement.value[cursorPosition - 2] && tempTrigElArr[cursorPosition] == triggerElement.value[cursorPosition - 1])
                {
                    tempTrigElArr.splice(cursorPosition - 1, 1); //Removing the character at the cursor position.
                    triggerElement.value = tempTrigElArr.join(''); //Joining the array back into a string.
                    triggerElement.setSelectionRange(cursorPosition, cursorPosition); //Setting the cursor position to the original position.
                }
            }
        });
console.log("fillBrackets called and done"); //Saying that the function is done.
}
