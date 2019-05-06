<template>
	<div>
		<!--begin::Modal-->
		<div class="modal fade" id="m_modal_create_user" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">
							{{ editing ? trans.get('universal.edit') : trans.get('universal.create') }}
						</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form class="m-form m-form--fit m-form--label-align-right">
							<div class="m-form__section m-form__section--first">
								<div class="form-group m-form__group row">
									<label for="name" class="col-lg-2 col-form-label">{{ trans.get('universal.full_name') }}</label>
									<div class="col-lg-8">
										<input v-model="user.name" type="text" class="form-control m-input" placeholder="" id="name">
										<span v-if="errors.name"class="m-form__help">{{ errors.name[0] }}</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="email" class="col-lg-2 col-form-label">{{ trans.get('universal.email') }}</label>
									<div class="col-lg-8">
										<input v-model="user.email" type="text" class="form-control m-input" placeholder="" id="email">
										<span v-if="errors.email"class="m-form__help">{{ errors.email[0] }}</span>
									</div>
								</div>
								<div class="form-group m-form__group row">
									<label for="password" class="col-lg-2 col-form-label">{{ trans.get('universal.password') }}</label>
									<div class="col-lg-8">
										<input v-model="user.password" type="password" class="form-control m-input" id="password">
										<span v-if="errors.password"class="m-form__help">{{ errors.password[0] }}</span>
									</div>
								</div>

								<div class="form-group m-form__group row">
									<label for="password" class="col-lg-2 col-form-label">{{ trans.get('universal.password_confirmation') }}</label>
									<div class="col-lg-8">
										<input v-model="user.password_confirmation" type="password" class="form-control m-input" id="password_confirmation">
									</div>
								</div>

								<div class="form-group m-form__group row" v-show="$gate.isAdmin() && user.role_id != 1">
									<label class="col-lg-2 col-form-label">
										{{ trans.get('companies.singular') }}
									</label>
									<div class="col-lg-8">
										<select class="form-control custom-select" id="company_id" 
										v-model="user.company_id"
										>
											<option value="">{{ trans.get('universal.choose') }}</option>
											<option v-for="company in companies" 
											:value="company.id"
											>
												{{ company.name }}
											</option>
										</select>

										<span v-if="errors.company_id"class="m-form__help">{{ errors.company_id[0] }}</span>
									</div>
								</div>

								<div class="form-group m-form__group row">
									<label for="birthdate" class="col-lg-2 col-form-label">{{ trans.get('universal.birthdate') }}</label>
									<div class="col-lg-8">
										<input type="text" v-model="user.birthdate" v-datepicker="user.birthdate"
											class="form-control" 
											:placeholder="trans.get('universal.choose')" 
											id="birthdate"
											readonly 
											>
										<span v-if="errors.birthdate"class="m-form__help">{{ errors.birthdate[0] }}</span>
									</div>
								</div>

								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">
										{{ trans.get('universal.city') }}
									</label>
									<div class="col-lg-8">
										<select class="form-control custom-select" id="city_id" 
										v-model="user.city_id" 
										>
											<option value="">{{ trans.get('universal.choose') }}</option>
											<option v-for="geo in geos" 
											:value="geo.id"
											>
												{{ geo.name }}
											</option>
										</select>

										<span v-if="errors.city_id"class="m-form__help">{{ errors.city_id[0] }}</span>
									</div>
								</div>

								<div class="form-group m-form__group row">
									<label for="address" class="col-lg-2 col-form-label">{{ trans.get('universal.address') }}</label>
									<div class="col-lg-8">
										<input v-model="user.address" type="text" class="form-control m-input" id="address">
										<span v-if="errors.address"class="m-form__help">{{ errors.address[0] }}</span>
									</div>
								</div>

								<div class="form-group m-form__group row">
									<label for="phone" class="col-lg-2 col-form-label">{{ trans.get('universal.phone') }}</label>
									<div class="col-lg-8">
										<input v-model="user.phone" v-mask="'### #######'" type="text" class="form-control m-input" id="phone">
										<span v-if="errors.phone"class="m-form__help">{{ errors.phone[0] }}</span>
									</div>
								</div>

								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label" for="photo">{{ trans.get('universal.photo') }}</label>
									<div class="col-lg-8">
										<input type="file" class="form-control m-input" v-on:change="onFileChange('user', 'photo')" id="photo">
										<span v-if="errors.photo"class="m-form__help">{{ errors.photo[0] }}</span>
									</div>
								</div>
							</div>

							<div class="m-form__seperator m-form__seperator--dashed"></div>
							<div class="m-form__section m-form__section--last">
								<div class="m-form__heading">
									<h3 class="m-form__heading-title">{{ trans.get('users.permissions') }}</h3>
								</div>
								<div class="m-form__group form-group row">
									<label class="col-lg-2 col-form-label">
										{{ trans.get('universal.role') }}
									</label>
									<div class="col-lg-6">
										<div class="m-radio-list">
											<label v-for="role in roles" class="m-radio">
												<input type="radio" v-model="user.role_id" :value="role.id"> {{ trans.get('universal.' + role.name) }}
												<span></span>
											</label>
										</div>
										<span v-if="errors.role_id"class="m-form__help">{{ errors.role_id[0] }}</span>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button v-if="editing" type="button"
							class="btn btn-primary" 
							v-bind:class="{'m-btn m-loader m-loader--light m-loader--right': saving}"
							@click="editUser"
							:disabled="saving"
							>
							{{ trans.get('universal.edit') }}
						</button>

						<button v-else type="button" 
							class="btn btn-primary"
							v-bind:class="{'m-btn m-loader m-loader--light m-loader--right': saving}" 
							@click="createUser"
							:disabled="saving"
							>
							{{ trans.get('universal.create') }}
						</button>
					</div>
				</div>
			</div>
		</div>

		<!--end::Modal-->
	</div>
</template>

<script>
	import {onFileChange} from '../../../Helpers'
	import {setFileValue} from '../../../Helpers'

	class User{
		constructor(user){
			this.id = user.id || '';
			this.name = user.name || '';
			this.photo = '';
			this.email = user.email || '';
			this.birthdate = user.birthdate || '';
			this.address = user.address || '';
			this.phone = user.phone || '';
			this.password = '';
			this.password_confirmation = '';
			this.city_id = user.city_id || '';
			this.role_id = user.role_id || '';
			this.company_id = user.company_id || '';
		}
	}

	export default{
		props: ['roles', 'companies', 'geos'],
		data(){
			return {
				user: {},
				errors: {},
				editing: false,
				user_company_id: this.$gate.getCompanyId(),
				saving: false
			}
		},
		mounted(){
			this.$parent.$on('create_user', () => {
				this.setFileValue('#photo', '', 'user', 'photo');
				this.editing = false;
				this.user = new User({});
				this.errors = {};

				this.$helpers.changeSelect('#company_id', this.user.company_id);
			});

			this.$parent.$on('edit_user', ({user}) => {
				this.setFileValue('#photo', '', 'user', 'photo');
				this.editing = true;
				this.user = new User(user);
				this.errors = {};

				this.$helpers.changeSelect(this.user.company_id);
				this.$helpers.setDate('#birthdate', moment(this.user.birthdate).format('DD-MM-YYYY'))
			});
		},
		methods: {
			createUser(){
				this.saving = true;
				if(this.user_company_id > 0){
					this.user.company_id = this.user_company_id;
				}

				axios.post('/api/users', this.user)
				.then(response => {
					this.saving = false;
					this.$parent.$emit('user_created', response.data.data);

					this.$helpers.modalHide('#m_modal_create_user');
					
				}).catch(error => {
					this.saving = false;
					this.errors = error.response.data.errors;
				});
			},
			editUser(){
				this.saving = true;
				axios.put('/api/users/' + this.user.id, this.user)
				.then(response => {
					this.saving = false;
					this.$parent.$emit('user_updated', response.data.data);

					this.$helpers.modalHide('#m_modal_create_user');
					
				}).catch(error => {
					this.saving = false;
					this.errors = error.response.data.errors;
				});
			},
			onFileChange,
			setFileValue
		}
	}
</script>