define(["require","reactDev","chat/chatbox"],function(e){var t=e("reactDev"),n=e("chat/chatbox");t.render(t.createElement(n,{url:"/threads/get.json",pollInterval:2e3}),document.getElementById("example"))});