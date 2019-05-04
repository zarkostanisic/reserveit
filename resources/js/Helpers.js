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

export function getDateWithFormat(value, format){
	// value format
	return moment(value).format(format);
}

export function orderBy(field){
	if(this.order == 'asc') this.order = 'desc';
	else this.order = 'asc';
	if(field != this.orderField) this.order = 'asc';
	this.orderField = field;

	this.getAllWithFilter();
}

export function orderActive(field){
	return {
		'sorting_asc': this.order == 'asc',
		'sorting_desc': this.order == 'desc',
		'active': field == this.orderField
	}
}