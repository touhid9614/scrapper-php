window.onload = () => {
	setTimeout(() => {
		console.log("Resetting ai buttons after 8 seconds of page load");
		new sMedia.AiButton().Register();
	}, 8000);
};
