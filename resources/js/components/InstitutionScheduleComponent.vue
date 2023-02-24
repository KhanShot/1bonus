<template>
    <div>
        <div class="form-group col-md-12">
            <div>
                <div class="d-flex flex-row align-items-center mb-4">
                    <div class="col">Понедельник</div>
                    <div class="col d-flex align-items-center">
                        c <input type="time" v-model="work_schedule.mon.open" :disabled="setDisabled(work_schedule.mon.dayoff)" class="form-control col-md-6 mr-4" >
                        до <input type="time" v-model="work_schedule.mon.close" :disabled="setDisabled(work_schedule.mon.dayoff)" class="form-control col-md-6" >
                    </div>

                    <div class="col ml-5">
                        <label for="dayoff1" class="d-flex align-items-center">Выходной
                            <input type="checkbox" v-model="work_schedule.mon.dayoff" @change="setDayOff(work_schedule.mon)" min="1" max="24" id="dayoff1">
                        </label>
                    </div>

                </div>
                <hr>
                <div class="d-flex flex-row align-items-center mb-4">
                    <div class="col">Вторник</div>
                    <div class="col d-flex align-items-center">
                        c <input type="time" v-model="work_schedule.tue.open" :disabled="setDisabled(work_schedule.tue.dayoff)" class="form-control col-md-6 mr-4" >
                        до <input type="time" v-model="work_schedule.tue.close" :disabled="setDisabled(work_schedule.tue.dayoff)" class="form-control col-md-6" >
                    </div>

                    <div class="col ml-5">
                        <label for="dayoff2" class="d-flex align-items-center">Выходной
                            <input type="checkbox" v-model="work_schedule.tue.dayoff" @change="setDayOff(work_schedule.tue)" min="1" max="24" id="dayoff2">
                        </label>
                    </div>

                </div>
                <hr>
                <div class="d-flex flex-row align-items-center mb-4">
                    <div class="col">Среда</div>
                    <div class="col d-flex align-items-center">
                        c <input type="time" v-model="work_schedule.wed.open" :disabled="setDisabled(work_schedule.wed.dayoff)" class="form-control col-md-6 mr-4" >
                        до <input type="time" v-model="work_schedule.wed.close" :disabled="setDisabled(work_schedule.wed.dayoff)" class="form-control col-md-6" >
                    </div>

                    <div class="col ml-5">
                        <label for="dayoff3" class="d-flex align-items-center">Выходной
                            <input type="checkbox" v-model="work_schedule.wed.dayoff" @change="setDayOff(work_schedule.wed)" min="1" max="24" id="dayoff3">
                        </label>
                    </div>

                </div>
                <hr>
                <div class="d-flex flex-row align-items-center mb-4">
                    <div class="col">Четверг</div>
                    <div class="col d-flex align-items-center">
                        c <input type="time" v-model="work_schedule.thu.open" :disabled="setDisabled(work_schedule.thu.dayoff)" class="form-control col-md-6 mr-4" >
                        до <input type="time" v-model="work_schedule.thu.close" :disabled="setDisabled(work_schedule.thu.dayoff)" class="form-control col-md-6" >
                    </div>

                    <div class="col ml-5">
                        <label for="dayoff4" class="d-flex align-items-center">Выходной
                            <input type="checkbox" v-model="work_schedule.thu.dayoff" @change="setDayOff(work_schedule.thu)" min="1" max="24" id="dayoff4">
                        </label>
                    </div>
                </div>
                <hr>
                <div class="d-flex flex-row align-items-center mb-4">
                    <div class="col">Пятница</div>
                    <div class="col d-flex align-items-center">
                        c <input type="time" v-model="work_schedule.fri.open" :disabled="setDisabled(work_schedule.fri.dayoff)" class="form-control col-md-6 mr-4" >
                        до <input type="time" v-model="work_schedule.fri.close" :disabled="setDisabled(work_schedule.fri.dayoff)" class="form-control col-md-6" >
                    </div>

                    <div class="col ml-5">
                        <label for="dayoff5" class="d-flex align-items-center">Выходной
                            <input type="checkbox" v-model="work_schedule.fri.dayoff" @change="setDayOff(work_schedule.fri)" min="1" max="24" id="dayoff5">
                        </label>
                    </div>
                </div>
                <hr>
                <div class="d-flex flex-row align-items-center mb-4">
                    <div class="col">Суббота</div>
                    <div class="col d-flex align-items-center">
                        c <input type="time" v-model="work_schedule.sat.open" :disabled="setDisabled(work_schedule.sat.dayoff)" class="form-control col-md-6 mr-4" >
                        до <input type="time" v-model="work_schedule.sat.close" :disabled="setDisabled(work_schedule.sat.dayoff)" class="form-control col-md-6" >
                    </div>

                    <div class="col ml-5">
                        <label for="dayoff6" class="d-flex align-items-center">Выходной
                            <input type="checkbox" v-model="work_schedule.sat.dayoff" @change="setDayOff(work_schedule.sat)" min="1" max="24" id="dayoff6">
                        </label>
                    </div>

                </div>
                <hr>
                <div class="d-flex flex-row align-items-center mb-4">
                    <div class="col">Воскресенье</div>
                    <div class="col d-flex align-items-center">
                        c <input type="time" v-model="work_schedule.sun.open" :disabled="setDisabled(work_schedule.sun.dayoff)" class="form-control col-md-6 mr-4" >
                        до <input type="time" v-model="work_schedule.sun.close" :disabled="setDisabled(work_schedule.sun.dayoff)" class="form-control col-md-6" >
                    </div>

                    <div class="col ml-5">
                        <label for="dayoff7" class="d-flex align-items-center">Выходной
                            <input type="checkbox" v-model="work_schedule.sun.dayoff" @change="setDayOff(work_schedule.sun)" min="1" max="24" id="dayoff7">
                        </label>
                    </div>

                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" @click="createSchedule" class="btn btn-info">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            work_schedule:{
                mon:{
                    open: null,
                    close:null,
                    dayoff: false,
                },
                tue:{
                    open:null,
                    close:null,
                    dayoff: false,
                },
                wed:{
                    open:null,
                    close:null,
                    dayoff: false,
                },
                thu:{
                    open:null,
                    close:null,
                    dayoff: false,
                },
                fri:{
                    open: null,
                    close: null,
                    dayoff: false,
                },
                sat:{
                    open:null,
                    close:null,
                    dayoff: false,
                },
                sun:{
                    open:null,
                    close:null,
                    dayoff: false,
                }

            },
            errors: [],
        }
    },
    props: ['institution'],
    mounted() {
        this.getWorkSchedule(this.institution.id)
    },
    methods:{
        setDayOff(day){
            if (day.dayoff){
                day.open = null;
                day.close = null;
            }
        },

        setDisabled(value){
            return !!value;
        },

        getWorkSchedule(id){
            axios
                .get('/partner/schedule/' + id)
                .then((response) => {
                    let sch = response.data.data.schedule;
                    if (sch.length === 7){
                        let newObj = {}
                        sch.forEach(sched => {
                            newObj[Object.keys(sched)[0]] = sched[Object.keys(sched)[0]]
                        })
                        this.work_schedule = newObj
                    }
                    else if (sch.length === 0){
                        this.work_schedule = {
                            mon:{
                                open: null,
                                close:null,
                                dayoff: false,
                            },
                            tue:{
                                open:null,
                                close:null,
                                dayoff: false,
                            },
                            wed:{
                                open:null,
                                close:null,
                                dayoff: false,
                            },
                            thu:{
                                open:null,
                                close:null,
                                dayoff: false,
                            },
                            fri:{
                                open: null,
                                close: null,
                                dayoff: false,
                            },
                            sat:{
                                open:null,
                                close:null,
                                dayoff: false,
                            },
                            sun:{
                                open:null,
                                close:null,
                                dayoff: false,
                            }

                        };
                    }
                });
        },

        createSchedule(){
            this.errors = [];
            axios
                .post('/partner/schedule/create/' + this.institution.id, this.work_schedule)
                .then((response) => {
                    if (response.data.success) {
                        swal(
                            'Данные обновлены!',
                            'Спасибо!',
                            'success');
                    }
                    this.getWorkSchedule(this.institution.id)
                }).catch((error) => {
                if (error.response.status === 422){
                    swal(
                        'Ошибка!',
                        'Пожалуйста проверьте все поля на правильность!',
                        'error'
                    )
                    for (const errorKey in error.response.data.errors) {
                        this.errors.push(errorKey)
                    }
                }
            })
        },
    }
}
</script>

<style scoped>

</style>
