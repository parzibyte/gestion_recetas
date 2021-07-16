const Utiles = {
	debounce(callback, wait) {
		let timerId;
		return (...args) => {
			clearTimeout(timerId);
			timerId = setTimeout(() => {
				callback(...args);
			}, wait);
		};
	}
};
export default Utiles;