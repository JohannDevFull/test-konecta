<template>

    <!-- Modal -->
    <div class="modal fade" :id="_id" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
            <div class="modal-body">

                <slot/>

            </div>
          
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
      </div>

    </div>

</template>

<style>
	
</style>

<script>


export default {
    props:['_id'  ],
    components: {
    },
    data() {
        return {
          count: 0
        }
    }
}
	
</script>