<template>
    <div class="m-2">
        <h2><i class="fas fa-list"></i> ジョブ一覧 <span class="mx-2 px-1 text-white bg-info">{{ jobNum }}</span></h2> 

        <AlertPanelComponent :is-show-alert="isShowAlert"
                            :alert-level="alertLevel"
                            :alert-icon-class="alertIconClass"
                            :alert-message="alertMessage">
        </AlertPanelComponent>

        <div class="float-right form-inline">
            <button type="button" class="m-1 btn btn-primary" @click="addJob"><i class="fas fa-plus"></i> ジョブ追加</button>
            <button type="button" class="m-1 btn btn-secondary" @click="updateList"><i class="fas fa-sync"></i></button>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="autoReloadCheck" v-model="isAutoReload" @change="onAutoReloadChanged">
                <label class="form-check-label" for="autoReloadCheck">自動更新</label>
            </div>

            <button type="button" class="m-1 btn btn-danger" @click="resetList"><i class="fas fa-trash"></i></button>
        </div>

        <div class="my-2"></div>

        <div class="p-2 shadow-sm">
            <b-table hover small :items="jobList" :fields="fields">
                <template slot="cell(status)" slot-scope="data">
                    <span :class="data.value.color"><i :class="data.value.icon"></i> {{ data.value.name }}</span>
                </template>
            </b-table>
        </div>
    </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator"
import AlertPanelComponent from "./AlertPanelComponent.vue"
import axios from "axios"
import { TablePlugin } from "bootstrap-vue"
Vue.use( TablePlugin );

@Component({
    components: {
        AlertPanelComponent
    }
})
export default class JobListComponent extends Vue {
    mounted() {
        console.log( 'JobListComponent mounted.' )

        Vue.nextTick( this.updateList )
    }

    jobList: any[] = []
    fields: any[] = []
    jobNum: number = 0;
    isAutoReload: boolean = false;

    // AlertPanelComponent
    isShowAlert = false
    alertLevel = "default"
    alertIconClass = ""
    alertMessage = ""

    addJob() {
        this.isShowAlert = false;

        axios.post( '/job-list' )
            .then( response => {
                this.jobList = response.data.jobList
                this.jobNum = this.jobList.length

                this.alertLevel = "success"
                this.alertIconClass = ""
                this.alertMessage = "ジョブを追加しました。"
                this.isShowAlert = true;
            })
            .catch( error => {
                this.alertLevel = "danger"
                this.alertIconClass = ""
                this.alertMessage = "ジョブの追加に失敗しました。"
                this.isShowAlert = true;
            })
    }

    updateList() {
        axios.get( '/job-list' )
            .then( response => {
                this.jobList = response.data.jobList
                this.fields = [
                    { key: "id", label: "ID" },
                    { key: "name", label: "ジョブ名" },
                    { 
                        key: "status",
                        label: "ステータス",
                        formatter: ( value: any, key: any, item: any ) => {
                            return {
                                icon: this.getStatusIcon( item.status ),
                                color: this.getStatusColor( item.status ),
                                name: this.getStatusName( item.status )
                            };
                        }
                    },
                    { key: "created_at", label: "作成日時" },
                    { key: "job_started_at", label: "ジョブ実行開始日時" },
                    { key: "job_completed_at", label: "ジョブ実行完了日時" },
                ]
                this.jobNum = this.jobList.length

                if( this.isAutoReload ) {
                    window.setTimeout( this.updateList, 1000 )
                }
            })
    }

    resetList() {
        this.isShowAlert = false;

        axios.post( '/job-list/reset' )
            .then( response => {
                this.jobList = response.data.jobList
                this.jobNum = this.jobList.length

                this.alertLevel = "success"
                this.alertIconClass = ""
                this.alertMessage = "ジョブリストをリセットしました。"
                this.isShowAlert = true;
            })
            .catch( error => {
                this.alertLevel = "danger"
                this.alertIconClass = ""
                this.alertMessage = "ジョブリストのリセットに失敗しました。"
                this.isShowAlert = true;
            })
    }

    onAutoReloadChanged() {
        if( this.isAutoReload ) {
            window.setTimeout( this.updateList, 1000 )
        }
    }

    getStatusName( status: number ) {
        var statusName :String
        switch( status ) {
            case 0: statusName = "準備中"; break;
            case 1: statusName = "ジョブ実行中"; break;
            case 2: statusName = "ジョブ失敗"; break;
            case 3: statusName = "ジョブ成功"; break;
            default: statusName = "不明";
        }

        return statusName
    }

    getStatusIcon( status: number ) {
        var statusIcon :String
        switch( status ) {
            case 0: statusIcon = "far fa-clock"; break;
            case 1: statusIcon = "fas fa-spinner fa-spin"; break;
            case 2: statusIcon = "fas fa-times"; break;
            case 3: statusIcon = "fas fa-check-circle"; break;
            default: statusIcon = "fas fa-question";
        }

        return statusIcon
    }

    getStatusColor( status: number ) {
        var statusColor :String
        switch( status ) {
            case 0: statusColor = ""; break;
            case 1: statusColor = "text-primary"; break;
            case 2: statusColor = "text-danger"; break;
            case 3: statusColor = "text-success"; break;
            default: statusColor = "text-muted";
        }

        return statusColor
    }
}

</script>