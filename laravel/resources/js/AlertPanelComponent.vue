<template>
    <div v-show="isShowAlert" class="alert" :class="'alert-' + alertLevel" role="alert">
        <i :class="alertIconClass"></i>&nbsp;{{ alertMessage }}
    </div>
</template>

<script lang="ts">
import { Vue, Component, Prop, Watch } from "vue-property-decorator"

@Component
export default class AlertPanelComponent extends Vue {
    @Prop( { default: false } )
    isShowAlert!: boolean;

    @Prop( { default: "default" } )
    alertLevel!: string;

    @Prop( { default: "" } )
    alertIconClass!: string;

    @Prop( { default: "" } )
    alertMessage!: string;
}

</script>