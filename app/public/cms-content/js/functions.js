let messageBox = document.getElementById("whaleMessage");
const formDashboardContainer = document.getElementById("formDashboardContainer");
const markdownOption = document.getElementById("markdownOption");
const editorOption = document.getElementById("editorOption");

function messageForgotPassword() {
    messageBox.innerText = "Oh no that's so sad. I'm sorry I can't help you I'm just a whale.";
}

function openCreatePageForm() {
    formDashboardContainer.style.display = "block";
}

function closeCreatePageForm() {
    formDashboardContainer.style.display = "none";
}

function showEditor() {
    markdownOption.style.display = "none";
    editorOption.style.display = "block";
}

function showMarkdown() {
    markdownOption.style.display = "block";
    editorOption.style.display = "none";
}