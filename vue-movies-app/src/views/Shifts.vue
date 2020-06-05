<template>
  <div>
    <h1>{{movie.name}}</h1>
    <Errors v-if="errors.length" :errors="errors"/>
    <div class="text-right">
      <v-btn color="green" dark class="mb-2" @click="showFormDialog = true">Agregar</v-btn>
    </div>
    <ShiftList
      :shifts="shifts"
      :total-shifts="totalShifts"
      :get-shifts="getShifts"
      :edit-shift="requestToEditShift"
      :delete-shift="requestToDeleteShift"
    />
    <ShiftForm
      :shift-data="shift"
      :show-dialog="showFormDialog"
      :close-dialog="closeFormDialog"
      :save-shift="saveShift"
      :errors="errorsForm"
    />
    <ShiftDelete
      :show-dialog="showDeleteDialog"
      :close-dialog="closeDeleteDialog"
      :delete-shift="deleteShift"
    />
    <div class="text-right">
      <v-btn color="secondary" dark class="mb-2" @click="$router.back()">Regresar</v-btn>
    </div>
  </div>
</template>

<script>
  import ShiftList from '../components/shifts/ShiftList';
  import ShiftForm from '../components/shifts/ShiftForm';
  import ShiftDelete from '../components/shifts/ShiftDelete';
  import Errors from '../components/common/Errors';
  import axios from '../config/axios';

  export default {
    name: 'Shifts',
    props: ['id', 'movie'],
    components: {
      ShiftList,
      ShiftForm,
      ShiftDelete,
      Errors
    },
    data: () => ({
      shifts: [],
      totalShifts: 0,
      shift: {},
      shiftToDelete: {},
      showFormDialog: false,
      showDeleteDialog: false,
      errors: [],
      errorsForm: []
    }),
    methods: {
      async getShifts(options) {
        try {
          const {page, itemsPerPage, sortBy, sortDesc} = options;
          this.errors = [];
          let sortField = null;
          let sortDir = null;
          if (sortBy.length) {
            sortField = sortBy[0]
          }
          if (sortDesc.length) {
            if (sortDesc[0]) {
              sortDir = 'desc'
            } else {
              sortDir = 'asc'
            }
          }
          this.loading = true;
          const response = await axios.get(`/movies/${this.id}/shifts`, {
            params: {
              page,
              itemsPerPage,
              sortField,
              sortDir
            }
          });
          this.shifts = response.data.data;
          this.totalShifts = response.data.meta.total;
        } catch (e) {
          this.errors = ['Ocurrió un error al tratar de obtener las turnos'];
        } finally {
          this.loading = false;
        }
      },
      async storeShift(shift) {
        try {
          const request = await axios.post(`/movies/${this.id}/shifts`, shift);
          this.shifts.unshift(request.data.data);
          this.totalShifts++;
          this.closeFormDialog();
        } catch (e) {
          const response = e.response;
          if (response.status === 422) {
            this.errorsForm = response.data.errors;
          } else {
            this.errorsForm = ['Ocurrió un error al tratar de crear el turno'];
          }
        }
      },
      async updateShift(shift) {
        try {
          const request = await axios.put(`/shifts/${shift.id}`, shift);
          const index = this.shifts.findIndex(item => item.id === shift.id);
          this.shifts.splice(index, 1, request.data.data);
          this.closeFormDialog();
        } catch (e) {
          const response = e.response;
          if (response.status === 422) {
            this.errorsForm = response.data.errors;
          } else {
            this.errorsForm = ['Ocurrió un error al tratar de actualizar el turno'];
          }
        }
      },
      async deleteShift() {
        try {
          const shift = this.shiftToDelete;
          await axios.delete(`/shifts/${shift.id}`);
          this.shifts = this.shifts.filter(item => item.id !== shift.id);
          this.totalShifts--;
        } catch (e) {
          this.errors = ['Ocurrió un error al tratar de eliminar el turno'];
        } finally {
          this.closeDeleteDialog();
        }
      },
      saveShift(shift) {
        shift.date_time = `${shift.date} ${shift.time}:00`;
        if (shift.id) {
          this.updateShift(shift)
        } else {
          this.storeShift(shift);
        }
      },
      requestToEditShift(shift) {
        this.shift = {...shift};
        this.showFormDialog = true;
      },
      closeFormDialog() {
        this.shift = {};
        this.showFormDialog = false;
        this.errorsForm = [];
      },
      requestToDeleteShift(shift) {
        this.shiftToDelete = {
          ...shift
        };
        this.showDeleteDialog = true;
      },
      closeDeleteDialog() {
        this.showDeleteDialog = false
      },
    }
  }
</script>
