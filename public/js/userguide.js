

class Userguide {

    constructor(guideId) {
        this.guideId = guideId;
        this.currentStep = 0;
        this.steps = [];
        this.completedCounter = 0;
        this.failedCounter = 0;
        this.isCanceled = false;
        this.log = [];

        this.__load();
    }

    __load() {
        fetch("/userguide/load/"+this.guideI, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        }).then(response => {
            response.json().then(data => {
                console.log(data);
                this.steps = data['steps'];
            });
        }).catch(error => {
            console.error(error);
        });
    }

}