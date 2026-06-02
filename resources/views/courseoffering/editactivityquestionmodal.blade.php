

<input type="hidden" id="activity_id" name="activity_id" value="{{ $question->classActivity->id }}">
<input type="hidden" id="courseoffer_id" name="courseoffer_id" value="{{ $question->courseoffer->id }}">
<input type="hidden" id="activity_question_id" name="id" value="{{ $question->id }}">
    <div class="row">
        <div class="col-sm-6">  
            <div class="form-group">
                <label class="col-form-label">Name</label>
                <input class="form-control" type="text" id="name"  value="{{ $question->name }}" name="name">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Correct Answer (Answer Guide) </label>
                <input class="form-control" type="text"  id="answer"  value="{{ $question->answer }}" name="answer">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">CLO</label>
                <select id="model_clo_id" name="clo_id" class="select">
                <?php foreach($clos as $c){ ?>
                    <option value="{{$c->id}}" {{ $question->clo_id == $c->id ? 'selected' : '' }}>{{$c->code}}</option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Complexity </label>
                <select name="complexity" id="complexity"  class="select" >

                    <option value="1" {{ $question->question === "1" ? 'selected' : '' }}>Depth of knowledge required</option>
                    <option value="2" {{ $question->question === "2" ? 'selected' : '' }}>Range of conflicting requirements</option>
                    <option value="3" {{ $question->question === "3" ? 'selected' : '' }}>Depth of analysis required</option>
                    <option value="4" {{ $question->question === "4" ? 'selected' : '' }}>Familiarity of issues</option>
                    <option value="5" {{ $question->question === "5" ? 'selected' : '' }}>Extent of applicable codes</option>
                    <option value="6" {{ $question->question === "6" ? 'selected' : '' }}>Extent of stakeholder involvement and level of conflicting requiremen</option>
                    <option value="7" {{ $question->question === "7" ? 'selected' : '' }}>Interdependence</option>
                    <option value="8" {{ $question->question === "8" ? 'selected' : '' }}>Consequences</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Question Type</label>
                <select name="question" id="question" class="select">
                    <option value="T" {{ $question->question === "T" ? 'selected' : '' }}>Text Base</option>
                    <option value="R" {{ $question->question === "R" ? 'selected' : '' }}>Single Choice</option>
                    <option value="M" {{ $question->question === "M" ? 'selected' : '' }}>Multi Choice</option>
                    <option value="U" {{ $question->question === "U" ? 'selected' : '' }}>Attachment</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Total Marks</label>
                <input class="form-control" type="text"  value="{{ $question->max_mark }}" name="max_mark" id="max_mark">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">% OBE Weight</label>
                <input class="form-control" type="text"  value="{{ $question->obe_weight }}" name="obe_weight" id="obe_weight">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Question (Guidline for Question)</label>
                <textarea type="text" name="guidline" id="guidline"  class="form-control" placeholder="Enter Guidline">{{ $question->guidline}}</textarea>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Choices (Choices Guide) (Set Choices)</label>
                <textarea type="text" name="choices" id="choices" class="form-control" placeholder="Enter Choices Guide">{{ $question->choices}}</textarea>
            </div>
        </div>
    </div>
    
    
    <button id="updateclassactivityquestion"  class="btn btn-primary" onclick="updateClassActivityQuestion('{{route('updateclassactivityquestion')}}')">Submit</button>