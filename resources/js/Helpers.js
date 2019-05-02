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