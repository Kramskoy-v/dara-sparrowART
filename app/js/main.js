
const select = document.querySelector('select');
const allLang = ['ru', 'en'];

select.addEventListener('change', changeUrlLang);

function changeUrlLang() {
	let lang = select.value;
	location.href = window.location.pathname + '#' + lang;
	location.reload();
}
function changeLang() {
	let hash = window.location.hash;
	hash = hash.substring(1);
	console.log(hash);
	if (!allLang.includes(hash)){
		location.href = window.location.pathname + '#ru';
		location.reload();
	}
	select.value = hash;
	document.querySelector('title').innerHTML = langArr['title'][hash];
	for (let key in langArr) {
		let elem = document.querySelector('.lang-' + key);
		if (elem) {
			elem.innerHTML = langArr[key][hash];
		}
	}
}
changeLang();

// Отправка данных на сервер
let modalWindow = document.querySelector('.modal');
let modalClose = document.querySelector('.modal__close');
modalClose.addEventListener('click', function () {
	modalWindow.classList.remove('modal--active')
});


function send(event, php) {
	event.preventDefault ? event.preventDefault() : event.returnValue = false;
	let req = new XMLHttpRequest();
	req.open('POST', php, true);
	req.onload = function () {
		if (req.status >= 200 && req.status < 400) {
			json = JSON.parse(this.response); // ie 11
			console.log(json);

			// ЗДЕСЬ УКАЗЫВАЕМ ДЕЙСТВИЯ В СЛУЧАЕ УСПЕХА ИЛИ НЕУДАЧИ
			if (json.result == 'success') {
				// Если сообщение отправлено
				modalWindow.classList.add('modal--active');
				form.reset();
			} else {
				// Если произошла ошибка
				alert('Ошибка. Сообщение не отправлено');
			}
			// Если не удалось связаться с php файлом
		} else { alert('Ошибка сервера. Номер: ' + req.status); }
	};

	// Если не удалось отправить запрос. Стоит блок на хостинге
	req.onerror = function () { alert('Ошибка отправки запроса'); };
	req.send(new FormData(event.target));
}
