

class UserGuide {

    static __instance = null;

    static startNewGuide(guideId) {
        if (UserGuide.__instance == null) {
            UserGuide.__instance = new UserGuide(guideId, 0);
        }
    }

    static startGuide(guideId, step) {
        if (UserGuide.__instance == null) {
            UserGuide.__instance = new UserGuide(guideId, step);
        }
    }

    constructor(guideId, startStep) {
        this.guideId = guideId;
        this.steps = [];
        this.currentStep = startStep;
        this.loaded = false;

        this.__load();
    }

    setStep(step) {
        this.currentStep = step;
        if(this.loaded) {
            this.__updateStep();
        }
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
                this.loaded = true;
            });
        }).catch(error => {
            console.error(error);
        });
    }

    __updateStep() {

    }

}