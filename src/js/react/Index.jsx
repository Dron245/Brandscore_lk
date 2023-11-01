import React from "react";
import ReactDOM from "react-dom/client";

const App = () => (
	<>
		<h1 className="title">В комнату заходит React</h1>
	</>
);

// Объект для вывода
const root = document.querySelector("#root")
	? document.querySelector("#root")
	: document.querySelector(".wrapper");

// Main rendering
ReactDOM.createRoot(root).render(
	<React.StrictMode>
		<App />
	</React.StrictMode>
);
