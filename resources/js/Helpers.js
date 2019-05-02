export default class Helpers{
	changeSelect(name, val){
		$(name).val(val).trigger('change');
	}

	modalHide(name){
		$(name).modal('hide');
	}

	setDate(name, value){
		// value format DD-MM-YYYY
		$(name).datepicker('setDate', value);
	}
}

export function onFileChange(c, p) {
	var e = window.event;
    let files = e.target.files || e.dataTransfer.files;
    if (!files.length)
        return;

    let reader = new FileReader();
    let vm = this;
    reader.onload = (e) => {
        vm[c][p] = e.target.result;
    };
    reader.readAsDataURL(files[0]);
};

export function setFileValue(name, val, c, p){
	let vm = this;
	vm[c][p] = null;
	$(name).val(val);
}