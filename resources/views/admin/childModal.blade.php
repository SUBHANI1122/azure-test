<div class="modal fade" id="childrenModal-{{ $ticket->id }}" tabindex="-1" aria-labelledby="childrenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="childrenModalLabel">Children Listing</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Age Group</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($ticket->ticket_details as $index=>$child)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $child->name }}</td>
                    <td>{{ $child->academy }}</td>
                    <td>€{{ academy_price()[$child->academy] }}</td>
                  </tr>
                @endforeach

            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
