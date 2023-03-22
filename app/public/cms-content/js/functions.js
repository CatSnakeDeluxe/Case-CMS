let messageBox = document.getElementById("whaleMessage");
const whaleContainer = document.querySelector(".whaleContainer");
const markdownOption = document.getElementById("markdownOption");
const editorOption = document.getElementById("editorOption");

// setTimeout(() => {
//     const dynamicMessage = document.getElementById("dynamicMessage");
//     dynamicMessage.style.display = "none";
// }, 2000);

function messageForgotPassword() {
    messageBox.innerText = "Oh no that's so sad. I'm sorry I can't help you I'm just a whale.";
}

function showEditor() {
    markdownOption.style.display = "none";
    editorOption.style.display = "block";
}

function showMarkdown() {
    markdownOption.style.display = "block";
    editorOption.style.display = "none";
}

function closeWhaleContainer() {
    whaleContainer.style.display = "none";
}