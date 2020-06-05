<template>
  <v-dialog persistent v-model="showDialog" max-width="290">
    <v-card>
      <v-card-title class="headline">Eliminar turno</v-card-title>
      <v-card-text>
        ¿Estas seguro de querer eliminar este registro?
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          color="secondary"
          text
          @click="closeDialog"
        >
          Cancelar
        </v-btn>
        <v-btn
          color="red"
          text
          @click="deleteShift"
        >
          Aceptar
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
  export default {
    name: 'ShiftDelete',
    props: {
      showDialog: Boolean,
      closeDialog: Function,
      deleteShift: Function
    }
  }
</script>
