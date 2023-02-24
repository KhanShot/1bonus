<template>
    <div class="row">
        <div class="col-md-3">
            <div class="h4 "> Создать категорию </div>
            <hr>
            <div class="form-group">
                <label for="category_name" >Название категории</label>
                <input type="text" v-model="category_name" required class="form-control" >
            </div>

            <div class="form-group d-flex justify-content-end">

                <button class="btn btn-success " @click="createCategory" >Создать</button>
            </div>
        </div>
        <div class="col-md-1">

        </div>
        <div class="col-md-8">
            <div class="h4 "> Добавить услугу </div>
            <hr>
            <div class="form-group">
                <label for="category" >Категория</label>
                <select v-model="service.category" class="form-control">
                    <option v-for="category in categories" :value="category.id">{{category.name}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="category" >Название услуги/товара</label>
                <input type="text" class="form-control" v-model="service.name">
            </div>
            <div class="form-group">
                <label for="category" >Цена услуги/товара</label>
                <input type="number" class="form-control" v-model="service.price">
            </div>
            <div class="form-group">
                <label for="category" >фотография</label>

                <input style="opacity: 1"
                       ref="fileInput"
                       type="file"
                       accept="image/*"
                       @change="onImageSelect"
                       >
            </div>

            <div class="form-group d-flex justify-content-end">
                <button class="btn btn-success " @click="createService" >Создать</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title">список услуг</h4>
                </div>
                <div class="card-body">
                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                            <tr>
                                <th>Фото</th>
                                <th>Категория</th>
                                <th>Названия услуги</th>
                                <th class="text-center">Цена</th>
                                <th class="text-center">действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="service in services">
                                <td><img :src="'/storage'+service.image" width="100"  ></td>
                                <td>{{service.category ? service.category.name : '-'}}</td>
                                <td>{{ service.name ?? "-" }}</td>
                                <td class="text-center">{{service.price ?? "-" }} Tг</td>
                                <td class="text-center">
                                    <button class="btn btn-danger" @click="deleteService(service.id)" type="submit"> <i class="fa fa-trash"></i> </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                category_name:null,
                categories: null,
                previewImage: null,
                services: [],
                service: {
                    category: null,
                    name: null,
                    price: null,
                    image: null,
                }
            }
        },
        mounted() {
            this.getCategories();
            this.getServicesList();
        },
        props: ['institution'],
        methods:{

            onImageSelect(event){
                this.service.image = event.target.files[0]
            },
            getCategories(){
                axios
                    .get('/partner/service-categories/' + this.institution.id)
                    .then((response) => {
                        this.categories = response.data;
                    });
            },

            getServicesList(){
                axios
                    .get('/partner/services/get-list/' + this.institution.id)
                    .then((response) => {
                        this.services = response.data;
                    });
            },
            createCategory(){
                axios
                    .post('/partner/service/category/create/' + this.institution.id, {name : this.category_name})
                    .then((response) => {
                        if (response.data.success) {
                            swal(
                                'Данные обновлены!',
                                'Спасибо!',
                                'success');
                        }
                        this.category_name = null
                        this.getCategories()
                    }).catch((error) => {
                    if (error.response.status === 422){
                        swal(
                            'Ошибка!',
                            '',
                            'error'
                        )

                    }
                })
            },

            createService(){
                let formData = new FormData();
                for ( let key in this.service ) {
                    formData.append(key, this.service[key]);
                }

                axios
                    .post('/partner/service/store/' + this.institution.id, formData)
                    .then((response) => {
                        if (response.data.success) {
                            swal(
                                'Данные обновлены!',
                                'Спасибо!',
                                'success');
                            // window.location.href = '/partner/services'
                            this.service.category = null
                            this.service.name = null
                            this.service.price = null
                            this.service.image = null
                            this.previewImage = null
                            this.$refs.fileInput.value = null
                            this.getServicesList()
                        }
                    }).catch((error) => {
                    if (error.response.status === 422){
                        swal(
                            'Ошибка!',
                            'Пожалуйста проверьте все поля на правильность!',
                            'error'
                        )

                    }
                })
            },

            deleteService(id){
                axios
                    .post('/partner/services/delete/' + id)
                    .then((response) => {
                        if (response.data.success){
                            swal({
                                icon: 'success',
                                title: response.data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            this.getServicesList();
                        }
                    }).catch((error) => {
                    swal(
                        'Ошибка!',
                        'Не удалось удалить услугу.',
                        'error'
                    )
                })
            },
        },
    }
</script>
