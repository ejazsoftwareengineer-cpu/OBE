

    <input type="hidden" id="activity_id" name="activity_id" value="{{ $activity->id }}">
    <input type="hidden" id="course_id" name="course_id" value="{{ $activity->course_id }}">
    <input type="hidden" id="course_section_id" name="course_section_id" value="{{ $activity->course_section_id }}">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Activity/Assesment</label>
                <select id="assesment_id" name="assesment_id" class="select" >
                    <option value="">- Select -</option>
                    @foreach ($assesment as $a)
                        <option value="{{ $a->id }}" {{ $activity->assesment_id === $a->id ? 'selected' : '' }}  >{{ $a->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Assesment Name</label>
                <input class="form-control" id="assesment_name" name="assesment_name" type="text" value="{{ $activity->assesment_name }}" name="assesment_name">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Assesment Date</label>
                <input class="form-control" id="assesment_date" name="assesment_date" type="text" value="{{ $activity->assesment_date }}" name="assesment_date">
            </div>
        </div>
        <!-- <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Assesment Total Mark</label>
                <input class="form-control" id="assesment_total_mark" name="assesment_total_mark" type="number" value="{{ $activity->assesment_total_mark }}" name="assesment_total_mark">
            </div>
        </div> -->
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">GPA Weight</label>
                <input class="form-control" id="assesment_gpa_weight" name="assesment_gpa_weight" type="number" value="{{ $activity->assesment_gpa_weight }}"  name="assesment_gpa_weight">
            </div>
        </div>
    </div>
    <button id="updateclassactivity"  class="btn btn-primary" onclick="updateClassActivity('{{route('updateclassactivity')}}')">Submit</button>