<template>
    <div>
        <div class="form-group col-md-3 d-flex flex-row">
            <label for="" class="col-md-8">Колчиество посещении (3-30)</label>
            <input type="number" id="count" v-model="count" class="form-control col-md-4" min="3" max="30">
        </div>
        <div class="mt-5">
            <div class="d-flex justify-content-between">
                <h4>Список посещении</h4>
                <div>
                    <a href="/partner/cards" class="btn-success btn">Назад</a>
                    <button class="btn-success btn" @click="createCard">Сохранить</button>
                </div>
            </div>
            <div class="row container mt-3">
                <div class="form-group d-flex flex-row flex-wrap">
                    <div class="card p-3 mr-4 mt-3" style="width: 120px" v-for="(card, index) in cards" :key="index" >
                        <div class="card-title"><h4>{{ card.index }}</h4></div>
                        <div class="">
                            <div>{{ card.bonus_name }}</div>
                            <button class="btn btn-success" data-toggle="modal" data-target="#washCardModal" v-on:click="openCardModal(index)">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div ref="washCardModal" class="modal fade" id="washCardModal" tabindex="-1" role="dialog" aria-labelledby="washCardModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="washCardModalLabel" > услуги {{cardId + 1}}</h5>
                        <button type="button" @click="closeWashCardModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-md-12">
                            <label for=""> Бонус для посещение {{ cardId + 1 }}</label>
                            <div class="d-flex">
                                <input type="text" class="form-control col-md-6" v-model="bonus_name" @change="setBonus">
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" @click="closeWashCardModal">сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            count: 1,
            cardId: null,
            services: [],
            selected: null,
            bonus_name: null,
            cards:[
                {
                    index: 1,
                    bonus_name: null,
                }
            ]
        }
    },
    props:['institution'],
    mounted() {
    },
    watch:{
        count(e){
            if (e > 30){
                this.count = 30
            }
            if (e === null || e === ''){
                this.count = 0
            }
            else if (e < -1){
                this.count = 3
            }
            this.cards = []
            for (let i = 0; i < parseInt(this.count) ; i++) {
                this.cards.push({index: i+1, bonus_name: null, bonus_check: true })
            }

        }
    },

    methods:{
        setBonus(){
            // alert("asd")
            this.cards[this.cardId].bonus_name = this.bonus_name;
            this.bonus_name = null
            // console.log(this.selected)
        },

        createCard(){
            axios
                .post('/partner/cards/store/' + this.institution.id, {'cards': this.cards})
                .then((response) => {
                    if (response.data.success) {
                        swal(
                            'Данные обновлены!',
                            'Спасибо!',
                            'success');
                    }
                    location.href = '/partner/cards'
                }).catch((error) => {
                swal(
                    'Ошибка!',
                    'Что то явно не так. попробуйте снова!',
                    'error'
                )
            })
        },
        openCardModal(id){
            let element = this.$refs.washCardModal.$el

            this.cardId = id
            this.bonus_name = this.cards[id].bonus_name
            $(element).modal('show')
        },


        closeWashCardModal(){
            $("#washCardModal").click();
        }
    }
}
</script>

<style scoped>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}
</style>
