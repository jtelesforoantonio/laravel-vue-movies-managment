<template>
  <v-data-table
    class="elevation-1"
    loading-text="cargando..."
    :server-items-length="totalShifts"
    :headers="headers"
    :items="Shifts"
    :loading="loading"
    :options.sync="options"
    :footer-props="{'items-per-page-options': itemsPerPage}"
  >
    <template v-slot:item.status="{item}">
      <v-chip
        text-color="white"
        small
        :color="statusColor(item.status)"
      >
        {{ statusLabel(item.status) }}
      </v-chip>
    </template>
    <template v-slot:item.actions="{item}">
      <v-icon
        small
        class="mr-2"
        color="primary"
        title="editar"
        @click="editShift(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        color="red"
        title="eliminar"
        @click="deleteShift(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      Sin datos para mostrar <br/>
      <v-btn color="primary" @click="handleGetShifts">Actualizar</v-btn>
    </template>
  </v-data-table>
</template>

<script>
  export default {
    name: 'ShiftList',
    props: {
      Shifts: Array,
      totalShifts: Number,
      getShifts: Function,
      editShift: Function,
      deleteShift: Function
    },
    data: () => ({
      headers: [
        {
          text: 'Turno',
          align: 'start',
          value: 'date_time',
        },
        {
          text: 'Estatus',
          value: 'status',
        },
        {
          text: 'Acciones',
          value: 'actions',
          sortable: false
        },
      ],
      itemsPerPage: [5, 10, 15],
      options: {},
      loading: false
    }),
    methods: {
      async handleGetShifts() {
        this.loading = true;
        await this.getShifts(this.options);
        this.loading = false;
      },
      statusColor(status) {
        let color = 'green';
        if (status === 'I') {
          color = 'orange'
        }

        return color;
      },
      statusLabel(status) {
        let label = 'Activo';
        if (status === 'I') {
          label = 'Inactivo';
        }

        return label;
      }
    },
    watch: {
      options: {
        handler() {
          this.handleGetShifts();
        },
        deep: true
      }
    }
  }
</script>
