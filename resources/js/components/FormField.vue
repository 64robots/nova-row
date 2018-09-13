<template>
  <r64-default-field
    :field="field"
    :hide-label="field.hideLabelInForms"
    :field-classes="field.fieldClasses"
    :wrapper-classes="field.wrapperClasses"
    :label-classes="field.labelClasses"
  >
    <template slot="field">
      <RowHeading :fields="fields" />
      <div
        v-for="row in values"
        :key="row.row_id"
        class="flex items-center border-40 border relative"
      >
        <component
          class="remove-bottom-border w-full"
          :key="`${row.row_id}${field.attribute}`"
          :ref="`${row.row_id}${field.attribute}`"
          v-for="field in fields"
          v-model="row[field.attribute]"
          :is="`form-${field.component}`"
          :resource-name="resourceName"
          :resource-id="resourceId"
          :field="field"
        />
        <span
          class="flex items-center justify-center bg-danger text-white p-2 m-2 w-6 h-6 rounded-full cursor-pointer font-bold"
          @click="rowToRemove = row.row_id"
        >x</span>
      </div>
      <div class="flex justify-end">
        <a
          class="btn btn-primary p-3 rounded cursor-pointer mt-3"
          @click="addRow"
        >{{ __('Add Row') }}</a>
      </div>
      <portal to="modals">
        <transition name="fade">
          <RowDeleteModal
            v-if="rowToRemove"
            @confirm="removeRow"
            @close="rowToRemove = null"
          />
        </transition>
      </portal>
    </template>
  </r64-default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';
import RowField from './RowField';
import RowHeading from './RowHeading';
import RowDeleteModal from './RowDeleteModal';

export default {
  mixins: [FormField, HandlesValidationErrors, RowField],

  components: { RowHeading, RowDeleteModal },

  props: ['resourceName', 'resourceId', 'field'],

  data() {
    return {
      rowToRemove: null,
      fields: this.field.fields
    };
  },

  watch: {
    values: {
      deep: true,
      handler(values) {
        const value = values.map(value => {
          const copy = Object.assign({}, value);
          delete copy.row_id;
          return copy;
        });
        this.value = JSON.stringify(value);
        this.$emit('input', value);
      }
    }
  },

  mounted() {
    this.values.forEach(value => {
      Object.keys(value).forEach(key => {
        if (key !== 'row_id') {
          const element = this.$refs[`${value.row_id}${key}`][0];
          element.handleChange(value[key]);
        }
      });
    });
  },

  methods: {
    addRow() {
      const obj = this.fields.reduce(function(result, field) {
        result[field.attribute] = '';
        return result;
      }, {});

      this.addItemToRow(obj);
    },

    removeRow() {
      const index = this.values.findIndex(
        row => row.row_id === this.rowToRemove
      );
      this.values.splice(index, 1);
      this.rowToRemove = null;
    },

    /*
    * Set the initial, internal value for the field.
    */
    setInitialValue() {
      this.value = this.field.value || [];
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || []);
    },

    /**
     * Update the field's internal value.
     */
    handleChange(value) {
      this.value = value;
    }
  }
};
</script>
