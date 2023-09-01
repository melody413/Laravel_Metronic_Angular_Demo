import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditMedicineCompanyComponent } from './edit-medicine-company.component';

describe('EditMedicineCompanyComponent', () => {
  let component: EditMedicineCompanyComponent;
  let fixture: ComponentFixture<EditMedicineCompanyComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditMedicineCompanyComponent]
    });
    fixture = TestBed.createComponent(EditMedicineCompanyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
