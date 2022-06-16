const alertModule = (positionX = 'left', positionY = 'top') => {
	const alertDiv = document.createElement('div'),
		translateX = positionX == 'left' ? 'translateX(-100%)' : 'translateX(100%)';

	if (positionX == 'left' || positionX == 'right') {
		alertDiv.style[positionX] = '15px';
	} else {
		console.error(
			'"positionX" must be "left" or "right" when initializing alertModule.'
		);
		return;
	}

	if (positionY == 'top') {
		alertDiv.style.top = '15px';
		alertDiv.style.flexDirection = 'column';
	} else if (positionY == 'bottom') {
		alertDiv.style.bottom = '15px';
		alertDiv.style.flexDirection = 'column-reverse';
	} else {
		console.error(
			'"positionY" must be "top" or "bottom" when initializing alertModule.'
		);
		return;
	}

	alertDiv.classList.add('alert-container');
	document.body.appendChild(alertDiv);

	function remove(alert) {
		alert.style.transform = translateX;
		alert.style.opacity = '0';
		setTimeout(() => alert.remove(), 500);
	}

	return {
		/**
		 * Creates a new alert with a certain type and a content.
		 * @param {string} content Content to display in the alert.
		 * @param {string} type Type of alert : 'success', 'warning', 'error' or nothing for a default message.
		 * @param {number} duration Display duration of the alert in seconds (0 for infinite).
		 * @param {boolean} dismissible Defines weither or not the alert may be dismissed by clicking on it.
		 */
		create({ content, type = 'message', duration = 5, dismissible = true }) {
			let alert = document.createElement('p');
			alert.classList.add('alert');
			if (type === 'success' || type === 'warning' || type === 'error') {
				alert.classList.add(`alert-${type}`);
			}
			alert.innerHTML = content;
			alert.style.transform = translateX;
			alert.style.opacity = '0';
			alertDiv.appendChild(alert);

			setTimeout(() => {
				alert.style.transform = '';
				alert.style.opacity = '1';
			}, 10);

			if (duration) {
				setTimeout(() => remove(alert), duration * 1000);
			}

			if (dismissible) {
				alert.style.cursor = 'pointer';
				alert.addEventListener('click', () => remove(alert));
			}
		},
	};
};

var alert = alertModule("right", "bottom");
