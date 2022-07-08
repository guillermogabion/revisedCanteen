<template>
     <v-dialog
    v-model="dialog"
    persistent
    width="29%"
    >
        <v-card>

            i am dialog
            {{this.editedItem.name}}
        </v-card>

    </v-dialog>

</template>

<script>
 export default {
    data() {
        return {
            editedItem: {
                name: '',
                description: '',
                image: '',
            },
        }
    },
    props: {
        dialog:{
            required: true,
            type: Boolean,
            default: false
        },
        id:{
            type:Number,
        }
    },
 }
</script>