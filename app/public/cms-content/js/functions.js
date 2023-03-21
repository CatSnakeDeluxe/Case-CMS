let messageBox = document.getElementById("whaleMessage");
const formDashboardContainer = document.getElementById("formDashboardContainer");
// const createPageBtn = document.getElementById("createPageBtn");

function messageForgotPassword() {
    messageBox.innerText = "Oh no that's so sad. I'm sorry I can't help you I'm just a whale.";
}

function openCreatePageForm() {
    formDashboardContainer.style.display = "block";
}

function closeCreatePageForm() {
    formDashboardContainer.style.display = "none";
}