<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                       <form  @submit.prevent="registrarEmail"> 
                        <div class="form-group">
                          <label class="form-control-label" for="text-input"><strong>Nombre</strong>(*)</label>
                          <input type="text" class="form-control" v-model="nombre" placeholder="Ingrese nombre completo" required>
                        </div>
                        <div class="form-group">
                           <label class="form-control-label" for="text-input"><strong>Teléfono</strong>(*)</label>
                           <input type="number" min="0" class="form-control" v-model="telefono" placeholder="Ingrese número teléfono" required>
                        </div>
                        <div class="form-group">
                           <label class="form-control-label" for="text-input"><strong>Email</strong>(*)</label>
                           <input type="email" class="form-control" v-model="email" placeholder="Ingrese email" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="text-input"><strong>Asunto</strong>(*)</label>
                            <textarea class="form-control" v-model="asunto" placeholder="Comentarios..." required></textarea >
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Enviar
                            <div class="spinner-border spinner-border-sm" role="status" v-if="processing">
                                 <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                       </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                    <div class="form-group row">
                    <div class="col-md-9">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                               <option value="nombre">Nombre</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarEmail(buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarEmail(buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>        
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Asunto</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="em in arrayEmail" :key="em.id">
                                <td v-text="em.nombre"></td>
                                <td v-text="em.telefono"></td>
                                <td v-text="em.email"></td>
                                <td v-text="em.asunto"></td>
                                <td>
                                    <span v-if="em.activo == 1" class="badge badge-success">Enviado</span>
                                </td>
                            </tr>
                            <tr class="table-danger" v-if="arrayEmail.length == 0">
                                <td colspan="5"><strong> No se encontraron registros.</strong></td>
                            </tr>                                   
                        </tbody>
                    </table>
                </div>  
            </div>
        </div>

    </div>
</template>

<script>
    export default {
       data (){
        return {
              nombre:"",
              email:"",
              telefono:"",
              asunto:"",
              processing:false,
              criterio : 'nombre',
              buscar : '',
              arrayEmail:[]
            }
       },
       methods: {
            registrarEmail(){
              let me = this;
                me.processing = true;
                axios.post('/email',{
                    'nombre': this.nombre,
                    'telefono': this.telefono,
                    'email':this.email,
                    'asunto':this.asunto,
                }).then(function (response) {
                    me.processing = false;
                    me.nombre = "";
                    me.telefono = "";
                    me.email = "";
                    me.asunto = "";
                    me.listarEmail('','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            listarEmail(buscar,criterio){
             let me=this;
                var url = '/email?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEmail = respuesta.emails;
                }).catch(function (error) {
                   console.log(error);
                });
            }
       },
       mounted(){
           this.listarEmail(this.buscar,this.criterio);
       }
    }
</script>
