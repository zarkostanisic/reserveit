<template>
	<div>
		<!--begin::Modal-->
		<div class="modal fade" id="m_modal_create_user" tabindex="-1" role="dialog" aria-hidden="true">
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
										<input v-model="user.password" type="text" class="form-control m-input" placeholder="" id="password">
										<span v-if="errors.password"class="m-form__help">{{ errors.password[0] }}</span>
									</div>
								</div>

								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">Objekat</label>
									<div class="col-lg-6">
										<select class="form-control m-select2" id="m_select2_1" name="param">
											<option value="AK">Alaska</option>
										</select>
									</div>
								</div>
							</div>

							<div class="m-form__seperator m-form__seperator--dashed"></div>
							<div class="m-form__section m-form__section--last">
								<div class="m-form__heading">
									<h3 class="m-form__heading-title">{{ trans.get('users.permissions') }}</h3>
								</div>
								<div class="m-form__group form-group row">
									<label class="col-lg-2 col-form-label">{{ trans.get('universal.role') }}</label>
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
						<button v-if="editing" type="button" class="btn btn-primary" @click="editUser">
							{{ trans.get('universal.edit') }}
						</button>

						<button v-else="editing" type="button" class="btn btn-primary" @click="createUser">
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
	class User{
		constructor(user){
			this.name = user.name || '';
			this.email = user.email || '';
			this.password = user.password || '';
			this.password_confirmation = user.password_confirmation || '';
			this.role_id = user.role_id || '';
		}
	}

	export default{
		props: ['roles'],
		data(){
			return {
				user: {},
				errors: {},
				editing: false
			}
		},
		mounted(){
			this.$parent.$on('create_user', () => {
				this.editing = false;
				this.user = new User({});
				this.errors = {};
			});

			this.$parent.$on('edit_user', ({user}) => {
				this.editing = true;
				this.user = new User(user);
				this.errors = {};
			});
		},
		methods: {
			createUser(){
				axios.post('/api/users', this.user)
				.then(response => {
					this.$parent.$emit('user_created', response.data.data);

					$('#m_modal_create_user').modal('hide');
					$('.modal-backdrop').remove();
				}).catch(error => {
					this.errors = error.response.data.errors;
				});
			},
			editUser(){
				alert('edit');
			}
		}
	}
</script>