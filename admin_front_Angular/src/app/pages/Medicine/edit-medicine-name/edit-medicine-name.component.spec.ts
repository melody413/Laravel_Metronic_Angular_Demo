import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditMedicineNameComponent } from './edit-medicine-name.component';

describe('EditMedicineNameComponent', () => {
  let component: EditMedicineNameComponent;
  let fixture: ComponentFixture<EditMedicineNameComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditMedicineNameComponent]
    });
    fixture = TestBed.createComponent(EditMedicineNameComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
