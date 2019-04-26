export default class Gate{
	constructor(user){
		this.user = user;
	}

	isAdmin(){
		return this.user.role.name == 'administrator';
	}

	isManager(){
		return this.user.role.name == 'manager';
	}

	isHostess(){
		return this.user.role.name == 'hostess';
	}
}