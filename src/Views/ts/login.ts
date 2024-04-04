class Form {
	public constructor() {
		this.SetEventCallback(this.GetForms(document.forms));
	}

	private GetForms(forms: HTMLCollectionOf<HTMLFormElement>): HTMLFormElement[] {
		return Array.from(forms);
	}

	private GetLabels(form: HTMLFormElement): NodeListOf<HTMLLabelElement> {
		return form.querySelectorAll('label');
	}

	private SetEventCallback(forms: HTMLFormElement[]): void {
		for (let form of forms) {
			for (let input of form.querySelectorAll('input')) {
				input.onblur = () => {
					this.ValidateInput(input, this.GetLabels(form));
				};
			}
		}
	}

	private ValidateInput(input: HTMLInputElement, labels: NodeListOf<HTMLLabelElement>): void {
		let label: HTMLLabelElement | null = null;

		switch (input.name) {
			case 'username':
				for (let i = 0; i < labels.length; i++) {
					if (labels[i].htmlFor === 'username') {
						label = labels[i];

						break;
					}
				}

				this.ValidateName(input.value, label);

				return;

			case 'email':
				for (let i = 0; i < labels.length; i++) {
					if (labels[i].htmlFor === 'email') {
						label = labels[i];

						break;
					}
				}

				this.ValidateEmail(input.value, label);

				return;

			case 'password':
				for (let i = 0; i < labels.length; i++) {
					if (labels[i].htmlFor === 'password') {
						label = labels[i];

						break;
					}
				}

				this.ValidatePassword(input.value, label);

				return;
		}
	}

	private ValidateName(text: string, label: HTMLLabelElement): void {
		if (text.length < 3) {
			label.innerHTML = 'Za krótka nazwa użytkownika!';
		} else if (text.length > 18) {
			label.innerHTML = 'Za długa nazwa użytkownika!';
		} else if (/[|\\/~^`:",;:?!()\[\]{}<>'&%$@*+-=\.]/.test(text)) {
			label.innerHTML = 'Nazwa użytkownika nie może zawierać znaków specjalnych!';
		} else if (/[0-9]/.test(text)) {
			label.innerHTML = 'Nazwa użytkownika nie może zawierać cyfr!';
		} else if (/[A-Z]/.test(text)) {
			label.innerHTML = 'Nazwa użytkownika nie może zawierać wielkich liter!';
		} else if (/[żźćńółęąśŻŹĆĄŚĘŁÓŃ]/.test(text)) {
			label.innerHTML = 'Nazwa użytkownika nie może zawierać polskich znaków!';
		}
	}

	private ValidateEmail(text: string, label: HTMLLabelElement): void {
		if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(text)) {
			label.innerHTML = 'Niepoprawny email!';
		}
	}

	private ValidatePassword(text: string, label: HTMLLabelElement): void {
		if (text.length < 12) {
			label.innerHTML = 'Hasło nie może zawierać mniej niż 12 znaków!';
		} else if (text.length > 20) {
			label.innerHTML = 'Hasło nie może zawierać więcej niż 20 znaków!';
		} else if (!/[0-9]/.test(text)) {
			label.innerHTML = 'Hasło musi zewierać co namniej jedną cyfrę!';
		} else if (!/[A-Z]/.test(text)) {
			label.innerHTML = 'Hasło musi zawierać co najmniej jedną dużą literę!';
		} else if (!/[a-z]/.test(text)) {
			label.innerHTML = 'Hasło musi zawierać co najmniej jedną małą literę!';
		} else if (/[żźćńółęąśŻŹĆĄŚĘŁÓŃ]/.test(text)) {
			label.innerHTML = 'Hasło nie może zawierać polskich znaków!';
		}
	}
}

function login(args?: any[], kwargs?: Record<string, any>): number {
	const main = document.getElementById('main') as Element;
	const registerBtn = document.getElementById('first_page') as Element;
	const loginBtn = document.getElementById('second_page') as Element;

	const form_register = document.querySelector('#form_register') as HTMLFormElement;
	const form_login = document.querySelector('#form_login') as HTMLFormElement;

	form_register.addEventListener('onsubmit', function (event) {
		const form_data: FormData = new FormData(form_register);
		let response = fetch("");

		if (response.ok) {
			// if HTTP-status is 200-299
			// get the response body (the method explained below)
			let json = response.json();
		} else {
			alert('HTTP-Error: ' + response.status);
		}
		event.preventDefault();
	});
	registerBtn.addEventListener('click', () => {
		main.classList.add('active');
	});

	loginBtn.addEventListener('click', () => {
		main.classList.remove('active');
	});

	return 0;
}

document.addEventListener('DOMContentLoaded', () => {
	login();
});
