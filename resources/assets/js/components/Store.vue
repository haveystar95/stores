<template>
    <div class="container">


        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Store</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="firstName">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="" v-model="name" value="{name}"
                           required="">
                    <div class="invalid-feedback">
                        Valid name is required.
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="lastName">Url</label>
                    <input type="text" class="form-control" id="url" v-model="url" placeholder="" value="{url}"
                           required="">
                    <div class="invalid-feedback">
                        Valid last name is required.
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="desc">Description</label>
                <input type="text" class="form-control" id="desc" placeholder="Desc" required="" v-model="description"
                       value="{description}">
                <div class="invalid-feedback" style="width: 100%;">
                    Your username is required.
                </div>
            </div>




            <div class="card" v-for="(link, index) in this.links">
                <h5 class="card-header">Link {{index+1}}</h5>
                <div class="card-body">

                    <label :for="'link-name-'+link.id">Name link</label>
                    <input type="text" class="form-control" :id="'link-name-'+link.id" v-model="link.name"
                           placeholder="" value="{link.name}"
                           required="">


                    <label :for="'link-url-'+link.id">Url link</label>
                    <input type="text" class="form-control" :id="'link-url-'+link.id" v-model="link.url" placeholder=""
                           value="{link.url}"
                           required="">



                    <div v-for="(parser, indexP) in link['parsers']">
                        <div class="jumbotron">

                            <label :for="'parser-level-'+link.id">Level</label>
                            <input type="text" class="form-control" :id="'parser-level-'+link.id" v-model="parser.level"
                                   placeholder="" value="{parser.level}"
                                   required="">

                        <label :for="'parser-id-'+link.id">Pattern</label>
                        <textarea :id="'parser-id-'+link.id" v-model="parser.pattern"
                                  class="form-control">{{parser.pattern}}</textarea>

                        <br>

                        <label :for="'parser-attribute-'+link.id">Атрибут</label>
                        <input type="text" class="form-control" :id="'parser-attribute-'+link.id" v-model="parser.property"
                               placeholder="" value="{parser.property}"
                               required="">

                        <label :for="'parser-field-'+link.id">Поле</label>
                        <input type="text" class="form-control" :id="'parser-field-'+link.id" v-model="parser.field"
                               placeholder="" value="{parser.field}"
                               required="">


                            <input v-if="indexP === 0" type="checkbox" class="form-check-input" :id="'parser-body-content-'+link.id" v-model="parser.is_body_content"
                                    value="{parser.is_body_content}"
                                   required="">
                            <label  v-if="indexP === 0" class="form-check-label" :for="'parser-body-content-'+link.id">Основной контент</label>
                            <br>
                            <input type="checkbox" class="form-check-input" :id="'parser-look-at-main-'+link.id" v-model="parser.look_at_main"
                                   value="{parser.look_at_main}"
                                   required="">
                            <label class="form-check-label" :for="'parser-look-at-main-'+link.id">Парсить с главной ссылки</label>

                            <hr>



                    </div>
                    </div>


                </div>
                <button class="btn btn-info mt-4" @click="addParseField(index, 1)">Add parse fields</button>


            </div>
            <button class="btn btn-dark" @click="addLink"> Add Link</button>
            <button class="btn btn-info mt-4" @click="save">Save</button>
            <button class="btn btn-info mt-4" @click="checkPattern(index)">Check</button>



        </div>

    </div>
</template>

<script>
    export default {
        name: "Store",
        data() {
            return {
                url: '',
                name: '',
                description: '',
                pattern1: '',
                pattern2: '',
                pattern3: '',
                store: {},
                result: '',
                method: 'text',
                links: {},
            }
        },

        methods: {
            getStore(id) {
                this.$api('getStores', {id: id}, {})
                    .then(res => {
                        // this.store = res;
                        this.url = res[0].url;
                        this.name = res[0].name;
                        this.description = res[0].description;
                        this.links = res[0].links;

                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            checkPattern(index) {
                this.$api('checkPattern', {}, {link: this.links[index]})
                    .then(res => {
                        this.result = res.parse();
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },

            addParseField(index, level) {
                console.log(index);
                this.links[index]['parsers'].push({'pattern' : '', 'field': '', 'property': '', 'level':'', 'look_at_main':false, 'is_body_content':false});
            },

            addLink() {
                this.links.push({'name' : '', 'store_id': this.$route.params.id, 'url': '', 'description':'', 'parsers': []});
            },

            save() {
                this.$api('saveStoreSettings', {}, {links:this.links, id:this.$route.params.id, url:this.url, name:this.name, description:this.description})
                    .then(res => {

                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        },

        mounted() {
            this.getStore(this.$route.params.id);
        }
    }

</script>

<style scoped>

</style>
