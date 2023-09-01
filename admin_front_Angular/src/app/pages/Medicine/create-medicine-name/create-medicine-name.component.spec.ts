import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateMedicineNameComponent } from './create-medicine-name.component';

describe('CreateMedicineNameComponent', () => {
  let component: CreateMedicineNameComponent;
  let fixture: ComponentFixture<CreateMedicineNameComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateMedicineNameComponent]
    });
    fixture = TestBed.createComponent(CreateMedicineNameComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
