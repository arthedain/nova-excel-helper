<template>
    <div >
        <heading class="mb-6">{{__('Nova Excel Helper')}}</heading>
        <card
            class="excel-tool bg-90 flex flex-col items-center justify-center w-full mb-2"
            style="min-height: 200px"
        >
            <h3 class="text-20">{{__('Select resource')}}</h3>
            <div class="m-2 w-3/5">
                <select
                    @change="modelError = false"
                    v-model="modelSelected"
                    ref="model"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                >
                    <option value="">-</option>
                    <option v-for="(item, key) in models" :value="key">{{ __(item) }}</option>
                </select>
            </div>
            <p style="color: red" v-if="modelError">{{__("Pleace, select resource")}}</p>
        </card>
        <div class="flex justify-center items-center flex-no-wrap">
            <card class="excel-tool bg-90 flex flex-col items-center justify-center w-1/2 mr-2">
                <div class="w-1/3 flex justify-between align-center items-center flex-col m-2" style="min-height: 200px">
                    <h3 class="text-20">{{__('Import')}}</h3>
                    <div class="flex justify-center flex-col items-center">
                        <div class="overflow-hidden relative w-64 mt-4 mb-1 btn btn-primary btn-primary" style="border-radius: .5rem;">
                            <button class="bg-indigo hover:bg-indigo-dark text-white font-bold py-2 px-4 w-full inline-flex items-center">
                                <svg fill="#FFF" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" >
                                    <path d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/>
                                </svg>
                                <span class="ml-2" v-if="fileName">{{ fileName }}</span>
                                <span class="ml-2" v-else>{{__('Select File')}}</span>
                            </button>
                            <input class="cursor-pointer absolute block opacity-0 pin-r pin-t h-full" @change="changeFile" type="file" name="file" ref="file">
                        </div>
                        <span class="text-70 text-sm italic">{{__('Load only Excel file')}}</span>
                    </div>
                    <p style="color: red" v-if="importError">{{ __(importErrorText) }}</p>
                    <button @click="importFile($event)" class="btn btn-default btn-primary m-4 mb-6">{{__('Import')}}</button>
                </div>
            </card>
            <card class="excel-tool bg-90 flex flex-col items-center justify-center w-1/2 ml-2">
                <div class="w-1/3 flex justify-between align-center items-center flex-col m-2" style="min-height: 200px">
                    <h3 class="text-20">{{__('Export')}}</h3>
                    <button @click="exportFile($event)" class="btn btn-default btn-primary mt-2 mb-6" :disabled="!modelSelected">
                        {{__('Export')}}</button>
                </div>
            </card>
        </div>

    </div>
</template>

<script>
export default {
    data(){
      return {
          fileName: null,
          modelError: false,
          importError: false,
          exportError: false,
          importErrorText: "Pleace, select file",
          modelSelected: null,
          models: [],
      };
    },
    mounted(){
        axios.get('/nova-vendor/nova-excel-helper/get-models').then((response) => {
            this.models = response.data;
        });
    },

    methods: {
        importFile:function(e){
            e.preventDefault();
            this.validateModel(e);
            this.validateFile(e);
            let file = this.$refs.file.files[0];
            let model = this.$refs.model.value;
            let form = new FormData();
            form.append('file', file);
            form.append('model', model);

            axios.post('/nova-vendor/nova-excel-helper/import', form).then((response) => {
                this.$toasted.show(this.__("Success"), {
                    type: "success"
                });
                this.clearFile();
            })
            .catch((error)=>{
                // console.log(error.response);
                this.$toasted.show(this.__(error.response.data.message), {
                    type: "error"
                });
                if(error.response.data.errors.file){
                    this.importError = true;
                    this.importErrorText = error.response.data.errors.file[0];
                }
            });


        },
        exportFile(e){
            this.validateModel(e);
            let model = this.$refs.model.value;
            let fileURL = "/nova-vendor/nova-excel-helper/export?model="+model+"&name="+this.models[model];
            let fileLink = document.createElement('a');

            fileLink.href = fileURL;
            fileLink.setAttribute('target', '_blank');
            document.body.appendChild(fileLink);

            fileLink.click();
        },
        changeFile(){
            let file = this.$refs.file.files[0];
            this.importError = false;
            if (file){
                this.fileName = file.name;
            }
            else{
                this.fileName = null;
            }
        },
        clearFile(){
            this.fileName = null;
            this.$refs.file.value = '';
        },
        validateModel(e){
            let model = this.$refs.model.value;
            if (!model){
                this.modelError = true;
                e.preventDefault();
            }

        },
        validateFile(e){
            let file = this.$refs.file.files[0];
            if(!file){
                this.importError = true;
                e.preventDefault();
            }
        }
    },
}
</script>

<style>
/* Scoped Styles */
</style>
