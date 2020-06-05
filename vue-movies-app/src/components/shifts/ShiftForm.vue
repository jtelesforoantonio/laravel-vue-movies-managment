<template>
  <v-dialog persistent v-model="showDialog" max-width="500px">
    <v-card>
      <v-card-title>
        <span class="headline">{{title}}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <Errors v-if="errors.length" :errors="errors"/>
          <v-row>
            <v-col cols="12" sm="6" md="6">
              <v-menu
                ref="menuDatePicker"
                v-model="datePicker"
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="shift.date"
                    label="Fecha"
                    readonly
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker
                  ref="picker"
                  v-model="shift.date"
                  @change="$refs.menuDatePicker.save(shift.date)"
                ></v-date-picker>
              </v-menu>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-menu
                ref="menuTimePicker"
                v-model="timePicker"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="shift.time"
                transition="scale-transition"
                offset-y
                max-width="290px"
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="shift.time"
                    label="Hora"
                    readonly
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-time-picker
                  v-if="timePicker"
                  v-model="shift.time"
                  full-width
                  @click:minute="$refs.menuTimePicker.save(shift.time)"
                ></v-time-picker>
              </v-menu>
            </v-col>
            <v-col cols="12" sm="12" md="12">
              <v-select
                v-model="shift.status"
                label="Estatus"
                item-value="id"
                item-text="status"
                :items="status"
              />
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="handleCancel">Cancelar</v-btn>
        <v-btn color="blue darken-1" text @click="handleSave">Guardar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
  import Errors from '../common/Errors';

  export default {
    name: 'ShiftForm',
    components: {Errors},
    props: {
      showDialog: Boolean,
      shiftData: Object,
      closeDialog: Function,
      saveShift: Function,
      errors: Array
    },
    data: () => ({
      title: 'Agregar turno',
      shift: {
        date: '',
        time: '',
        status: ''
      },
      datePicker: false,
      timePicker: false,
      status: [
        {
          id: 'A',
          status: 'Activo'
        },
        {
          id: 'I',
          status: 'Inactivo'
        }
      ]
    }),
    methods: {
      handleCancel() {
        this.shift = {};
        this.closeDialog();
      },
      handleSave() {
        this.saveShift(this.shift);
      }
    },
    watch: {
      shiftData: {
        handler(data) {
          this.shift = {...data};
          if (data.id) {
            this.title = 'Editar turno';
          } else {
            this.title = 'Agregar turno';
          }
        },
        deep: true
      }
    }
  }
</script>
