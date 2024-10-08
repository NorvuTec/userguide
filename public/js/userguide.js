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

    __load() {
        fetch("/userguide/load/"+this.guideId, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        }).then(response => {
            response.json().then(data => {
                this.steps = data['steps'];
                this.loaded = true;
                this.__loadStep(this.currentStep);
            });
        }).catch(error => {
            console.error(error);
        });
    }

    __loadStep(step) {
        if(!this.loaded) {
            return;
        }
        if(step === 0 || step === undefined) {
            // new start of the guide
            step = 1;
        }
        let stepData = this.__getStepData(step);
        if(stepData == null) {
            console.error("UserGuide: Step not found: "+step);
            return;
        }
        this.__removeLoadedTooltips();
        if(!this.__createTooltip(stepData)) {
            // Try next step if there is a missing element
            this.__loadStep(step+1);
            return;
        }
        if(this.currentStep < step) {
            this.__saveStepLoaded(step);
        }
        this.currentStep = step;
    }

    __getStepData(stepId) {
        for(let i = 0; i < this.steps.length; i++) {
            if(this.steps[i].step === parseInt(stepId)) {
                return this.steps[i];
            }
        }
        return null;
    }

    __removeLoadedTooltips() {
        Array.from(document.getElementsByClassName("userguide_window")).forEach(element => {
            element.remove();
        });
    }

    __createTooltip(stepData) {
        let targetElement = document.querySelector(stepData['selector']);
        if (targetElement === undefined) {
            console.error("UserGuide: No Element found: "+stepData['selector']);
            return false;
        }
        targetElement.insertAdjacentHTML("beforebegin", stepData["template"]);
        let newElement = targetElement.previousElementSibling;
        let usg = this;
        let nextElems = newElement.getElementsByClassName("guide-next");
        if(nextElems.length !== 0) {
            nextElems[0].addEventListener("click", () => {
                usg.__loadStep(usg.currentStep+1);
            });
        }
        let prevElems = newElement.getElementsByClassName("guide-prev");
        if(prevElems.length !== 0) {
            prevElems[0].addEventListener("click", () => {
                usg.__loadStep(usg.currentStep-1);
            });
        }
        let completeElems = newElement.getElementsByClassName("guide-complete");
        if(completeElems.length !== 0) {
            let usg = this;
            completeElems[0].addEventListener("click", () => {
                usg.__completeGuide();
            });
        }
        return true;
    }

    __completeGuide() {
        this.__removeLoadedTooltips();
        fetch("/userguide/set_guide_complete/" + this.guideId, {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            }
        }).then(r => {});


        UserGuide.__instance = null;
    }

    __saveStepLoaded(step) {
        // Save the step
        fetch("/userguide/set_step_loaded/" + this.guideId + "/" + step, {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            }
        }).then(r => {});
    }

    static addDocumentListeners() {
        document.querySelectorAll("[data-user-guide]").forEach(element => {
            element.addEventListener("click", function() {
                let guideId = element.getAttribute("data-user-guide");
                if(element.hasAttribute("data-user-guide-step")) {
                    let step = element.getAttribute("data-user-guide-step");
                    UserGuide.startGuide(guideId, step);
                    return;
                }
                UserGuide.startNewGuide(guideId);
            });
        });
    }

}
UserGuide.addDocumentListeners();